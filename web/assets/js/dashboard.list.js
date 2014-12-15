/**
 * Created by Czesieq on 2014-12-15.
 */

$(document).ready(function(){

    var prepareStateChanger = function(){
        $("a[data-state]").on('click', function(e){
            var sender = $(this);
            var state = $(this).data('state');
            var id = sender.parents('tr:first').data('uid')
            alert( id);
        });
    }

    var updateArticleStte = function(uid, state){
        $.ajax({
            url: ""
        })
    }

    prepareStateChanger();


});