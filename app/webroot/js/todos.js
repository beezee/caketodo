(function($, exports) {
    $('document').ready(function() {
        exports.appUrl = 'http://localhost/otherdev/caketodo/';
        
        $('#new-todo').bind('keyup', function(e) {
            if (e.keyCode === 13)
                $.post(appUrl+'todos/add/', {description: $(this).val()}, function() {
                    window.location.reload();
                })
        });
        
        $('.todo-done').click(function() {
            var done = $(this).is(':checked') ? 1 : 0;
            var todo = $(this).parent().parent().attr('id').replace('todo-', '');
            $.post(appUrl+'todos/edit/'+todo, {done : done}, function() {
                window.location.reload();
            });
        });
        
        $('.delete').click(function() {
            var todo = $(this).parent().parent().attr('id').replace('todo-', '');
            $.post(appUrl+'todos/delete/'+todo, {}, function(response) {
                window.location.reload();
            });
        });
        
        $('.edit').click(function() {
            var todo = $(this).parent().parent().attr('id').replace('todo-', '');
            var p = $(this).parent().parent().find('p');
            var text = p.text();
            var input = $('<input type="text" />');
            input.val(text);
            p.replaceWith(input);
            input.bind('keyup', function(e) {
                if (e.keyCode === 13) {
                    $.post(appUrl+'todos/edit/'+todo, {description: input.val()}, function() {
                        window.location.reload();
                    });
                }
            });
        });
        
    });
}(jQuery, window));