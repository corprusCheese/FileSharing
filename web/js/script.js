// функция для комментариев - подсвечивает кнопку ответа при нажатии
// и после выводит форму ответа (убирает hidden в css)
// jquery
$(document).ready(function(){
    $(document).on("click",'button[name="answer-button"]', function() {
        //Показывает скрытый комментарий для ответа
        var mycomment = $(".leave-comment");
        var cssDisplay = mycomment.css('display');
        if (cssDisplay == 'none')
            mycomment.css("display","block");
        else
            mycomment.css("display","none");

        //убрать у всех элементов анимацию
        var buttons = $('button[name="answer-button"]');
        $(buttons).css("animation", "none");

        //animation: shadow 1s infinite alternate
        //сует анимацию на нажатую кнопку ответить в комментарии
        var cssColor = $(this).css("background-color");
        if (cssColor.toString()=="rgb(40, 96, 144)") {
            $(this).css("animation", "shadow 1s infinite alternate");
            $(this).css("background-color",'rgb(42, 96, 144)');
        }
        else {
            $(this).css("animation", "none");
            $(this).css("background-color",'rgb(40, 96, 144)');
        }

        //Сует parentId в скрытый input
        var idcomment = ($(this).attr('id'));
        var mycommenttowhom = $('input[name="CommentForm[parentId]"]');
        mycommenttowhom.val(idcomment);
    })
});
