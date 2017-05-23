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

            $elems.live('click', function(){      

                var $element = $(this);

                var _userId = $element.data('udk-user-id');      
                var _key = $element.data('udk-key');      
                var _value = $element.data('udk-value');   

                var data = {
                    key: _key,
                    value: _value,
                    action: "udk_add",    
                };

                
                data.ajaxNonce = udk.ajaxNonce;

                $.post(udk.ajaxUrl, data, function(response) {               
                    console.log(response);            
                });               
               
                var clickEvent = new CustomEvent("udk-click", {detail: data} );
                document.dispatchEvent(clickEvent);    

                return false;
            });
        },

        init: function(){
            this.initAddElements();
            this.initRemoveElements();
            this.bindClick(this.$add);
            this.bindClick(this.$remove);
            
            // console.log($.fn.jquery);
            // alert('testing javascript!');
        },

        click: function(callback){
            document.addEventListener('udk-click', function(e){
                callback(e.detail);
            });
        }
    };


    $(document).ready(function($){
        UpUserDatakeeper.init();
        window.UDK = UpUserDatakeeper;
    });

})(jQuery);