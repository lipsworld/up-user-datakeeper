(function($){
    
    
    var UpUserDatakeeper = {

        $add: null,
        $remove: null,

        initAddElements: function(){
            this.$add = $('[data-udk-add]');
        },
        initRemoveElements: function(){
            this.$remove = $('[data-udk-remove]');
        },

        bindClick: function($elems){

            $elems.on('click', function(){
                alert('teste');
                $(this).trigger('udk-click', ['xxx']);
                return false;
            });
        },

        init: function(){
            this.initAddElements();
            this.initRemoveElements();
            this.bindClick(this.$add);
            this.bindClick(this.$remove);
            console.log($.fn.jquery);
            // alert('testing javascript!');
        }
    };


    $(document).ready(function($){
        UpUserDatakeeper.init();
    });

})(jQuery);







