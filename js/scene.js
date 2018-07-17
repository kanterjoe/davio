/**
 * Created by jkanter on 2/18/17.
 */

function makeid(length )
{
    if (!length) length = 5;
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < length; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
function get_scene (sceneid) {
    console.log("getting scene", sceneid);
    $.ajax( {
        cache:false,
        url:"/settings/scenes/"+sceneid,
        type: 'GET',
        dataType: "json",
        success : function (data) {new scene(data, sceneid)}
    })
}

var scene = function(data, file) {
    var data = data, file = file,
        collapsed_name  = data.name.replace(" ", "_"),
        scene_container = $("<div>", {id: collapsed_name+"-card", "class": "card mt-2 mb-2 p-1"}),
        scene_header    = $("<div>", {id: collapsed_name, "class": "card-header"}),
        scene_header_h  = $("<h5>", {"class": "mb-0"}),
        scene_header_a  = $("<a>", {"data-toggle": "collapse", "data-parent": "#scene-accordion",
            "href":"#collapse"+collapsed_name, "aria-expanded":"true", "aria-controls":"collapse"+collapsed_name }),
        //    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">

        // save_col        = $("<div class='col-md-1'>"),
        // input_col       = $("<div class='col-md-11'>"),
        // input_row       = $("<div class='row'>"),
        scene_name      = $("<input>",{class:"form-control", id:"scene-name", value: data.name}),
        scene_body_wrap = $("<div>",{id: "collapse"+collapsed_name, "class": "collapse", role:"tabpanel", "aria-labelledby": collapsed_name}),
        scene_body      = $("<div>",{class:"row justify-content-around bg-faded m-0 p-0"}),
        save_button     = $("<button>", {id: "save-button", "class": "btn btn-info w-100 ", type:"button"}).text("Save"),

        input_device_objs = [];

    var _get_data = function() {
        var input_devs = {};
        for (id_name in input_device_objs) {
            input_devs[id_name] = input_device_objs[id_name].get_data();
        }
        return {
            name : scene_name.val(),
            input_devices: input_devs
        }
    };
    var _save = function () {
        $.ajax( {
            url:"/form_handlers/write_file.php",
            type: 'POST',
            data: {file:"/settings/scenes/"+file, data:_get_data()},
            dataType: "json",
            success : function (data) {
                console.log("Successfully saved " + file, data);
                save_button.removeClass("saving");
                save_button.addClass("btn-success");
                save_button.removeClass("btn-warning");

            }
        });
        save_button.addClass("saving");
        save_button.addClass("btn-warning");

        save_button.removeClass("btn-info");

    };
    //make sub items
    for ( input_device_name in data.input_devices) {
        var id = new input_device(input_device_name,data.input_devices[input_device_name]);
        input_device_objs[input_device_name] = id;
        scene_body.append(id.get_element());
    }

    //Add everything to the DOM
    $('#scene-accordion').append(
        scene_container.append(
            scene_header.append(
                scene_header_h.append(
                    scene_header_a.append(scene_name)
                )
            )
        )
    );

    scene_container.append(scene_body_wrap);
    // save_col.append(save_button);
    // input_col.append(input_row.append(scene_body));
    scene_body_wrap
        .append(scene_body, save_button);
        // .append($("<div class = 'row'>").append(input_col,save_col));

    save_button.click(_save);

    return {
        save : function () {return _save()}
    }
};
var input_device = function(name, data) {
    var data         = data,
        name         = name,
        enabled      = data.enabled,
        id_wrapper   = $("<div>", {id: name+"-card", "class": "card col-md-4 m-3"}),
        id_container = $("<div>", {id: name+"-card", "class": "card-block"}),
        id_header    = $("<h4>", {id: name+"-card-header", "class": "card-title text-capitalize"}).text(name),
        add_button   = $("<button>", {id: name+"-add-button", "class": "btn btn-primary", type:"button"}).text("Add Action"),
        actions      = [];
    //do something with enabled
    id_wrapper.append(id_container);
    id_container.append(id_header);
    id_container.append(add_button);

    var _add_action = function (action_data) {
        if (!action_data) action_data = {
            "action":"No Action",
            "resource": "",
            "arguments":""
        };
        var act = new action(action_data);
        actions.push(act);
        id_container.append(act.get_element());
    };

    var _get_data = function () {
        var action_data = [], act;
        for (act in actions) {
            data = actions[act].get_data();
            if (data)
                action_data.push(data);
        }
        return {
            enabled: enabled,
            actions: action_data
        }
    };


    for (index in data.actions ) {
        _add_action(data.actions[index]);
    }

    add_button.click(_add_action);


    return {
        get_element: function() {return id_wrapper;},
        get_data: function () { return _get_data();}
        };
};
var action = function(data) {
    var act_wrapper   = $("<div>", {"class": "card mt-2 ", style:"min-width: 13em;"}),
        act_container = $("<div>", {"class": "card-block "}),
        data   = data,
        act_action, act_resource, act_arguments;

    var render = function () {
        /*
         <div class="input-group">
             <span class="input-group-addon" id="basic-addon1">@</span>
             <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
         </div>
         */
        act_action      = available_actions_dropdown(data.action);
        act_resource    = available_resources_dropdown(data.action, data.resource);
        act_arguments   = $("<input>", {id: "", "class": "input", type:"input"});

        act_container.html("<label>Action:</label>");
        act_container
            .append(act_action)
            .append("<label>Resource:</label>")
            .append(act_resource);


        act_action.change(_action_change);

    };
    var _get_data = function () {

        if (act_action.val() == "No Action")
            return false;
        else {
            return {
                action: act_action.val(),
                resource: (act_resource ? act_resource.val() : false),
                arguments: ""
            }
        }
    };
    var _action_change = function (e) {
        data.action = act_action.val();
        render();
    };
    render();

    act_wrapper.append(act_container);

    return {
        get_element: function() {return act_wrapper;},
        get_data: function() {return _get_data();}

    }
};

var new_scene = function () {
    var buttons = {};
    $.ajax( {
        url:"/settings/gpio_mappings.json",
        type: 'GET',
        dataType: "json",
        success : function (data) {buttons = data}
    });

    return function () {
        var final_data  = {name:"New Scene", input_devices:{}},
            file        = makeid(6) + ".json";

        for (buttonName in buttons) {
            final_data.input_devices[buttonName] = {enabled: true, actions:[]};
        }

        $.ajax( {
            url:"/form_handlers/write_file.php",
            type: 'POST',
            data: {file:"/settings/scenes/"+file, data:final_data},
            dataType: "json",
            success : function (data) {get_scene(file);}
        })

    }

} ();

$("#new-scene-button").click(new_scene);

