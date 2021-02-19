/* variable con la url del proyecto */
var url = 'http://projecto-laravel.com.devel/';




/* mensaje cuando se carga la pagina web */
window.addEventListener('load', function(){

    $('.red').css('cursor', 'pointer');
    $('.corazon').css('cursor', 'pointer');
    
        /* boton de like */
        function like(){

            $('.corazon').unbind('click').click(function(){
                console.log('like');
                $(this).removeClass('corazon').addClass('red');
                $(this).attr('class', 'fas fa-heart red');
                /* funcion ajax */
                $.ajax({
                    url: url+'like/'+$(this).data('id'),
                   type: 'GET',
                   success: function(response){
                    if(response.like){
                        console.log("has dado like a la publicacion");
                    }else{
                        console.log("error al dar like")
                    }
                   }
                });
                

                dislike();
                
            })


        }
        like();

        /* boton de dislike */
        function dislike(){

                
        $('.red').unbind('click').click(function(){
            console.log('dislike');
            $(this).removeClass('red').addClass('corazon');
            $(this).attr('class', 'far fa-heart corazon');


            $.ajax({
                url: url+'dislike/'+$(this).data('id'),
               type: 'GET',
               success: function(response){
                if(response.like){
                    console.log("has dado dislike a la publicacion");
                }else{
                    console.log("error al dar dislike")
                }
               }
            });
            
            like();
                
            })


        }
        dislike();




        /* para el buscador */
        $('#buscador').submit(function(){
           
            $(this).attr('action',url+'gente/'+$('#search').val() )
           

        })


});


