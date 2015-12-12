/**
 * Created by alexandre on 12/12/15.
 */

$(document).ready(function(){
    console.log('just for test json!');
    $.ajax({
        url: '/json-test',
        type: 'json',
        success : function(r){
            console.log(r);
        }
    });
});
