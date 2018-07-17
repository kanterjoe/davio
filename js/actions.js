/**
 * Created by jkanter on 2/18/17.
 */

var selectList = function (list, selected, attributes){
    console.log("making select list", list, selected);
    if (!attributes) attributes = {};
    Object.assign(attributes, {"class":"form-control"});

    var select = $("<select>", attributes);

    if (list.constructor === Array) {

        for (index in list) {

            var item        = list[index],

                opt         = $("<option>").text(item);
            if (item==selected) {
                opt.attr("selected", "True");
            }
            select.append(opt);
        }
    }
    else if (typeof list === 'object') {
        for (index in list) {

            var item        = list[index],
                opt         = $("<option value='"+item+"'>").text(index);
            if (item==selected) {
                opt.attr("selected", "True");
            }
            select.append(opt);
        }
    }


    return select;
};

var available_actions_dropdown = function () {
    var available_actions_list = [];
    $.ajax( {
        url:"/settings/available_actions.json",
        type: 'GET',
        dataType: "json",
        success : function (data) {available_actions_list = data}
    });

    return function (selected) {
        return selectList(available_actions_list,selected);
    }

} ();
var available_resources_dropdown = function () {
    var available_audio_list = [];
    var available_lights_list = [];

    $.ajax( {
        url:"/resources/get_json.php",
        type: 'GET',
        dataType: "json",
        data: {resource_type: "audio"},
        success : function (data) {available_audio_list = data}
    });
    $.ajax( {
        url:"/resources/get_json.php",
        type: 'GET',
        dataType: "json",
        data: {resource_type: "lights"},
        success : function (data) {available_lights_list = data}
    });

    return function (action, selected) {
        var sl = false;
        if (action == "Play Audio") sl = selectList(available_audio_list, selected);
        if (action == "Light Sequence") sl = selectList(available_lights_list, selected);
        return sl;
    }

} ();