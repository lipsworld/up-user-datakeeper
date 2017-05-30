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

            $elems.attr("data-udk-elems", '');

            $elems.live('click', function(){      

                var $element = $(this);

                var _userId = $element.data('udk-user-id');      
                var _key = $element.data('udk-key');      
                var _value = $element.data('udk-value');   

                var data = {
                    key: _key,
                    value: _value,
                    userId: _userId,
                    action: "udk_add",    
                };
                
                data.ajaxNonce = udk.ajaxNonce;

                $.post(udk.ajaxUrl, data, function(response) {               
                    // console.log(response);      
                    
                    var eventData = response;
                    eventData.$elem = $element;

                    var clickEvent = new CustomEvent("udk-click", {detail: eventData} );
                    document.dispatchEvent(clickEvent);
                                                
                });               
               
               

                return false;
            });
        },

        init: function(){
            this.initAddElements();
            this.initRemoveElements();
            this.bindClick(this.$add);
            this.bindClick(this.$remove);
        
        },

        click: function(callback){
            document.addEventListener('udk-click', function(e){

                var $elem = e.detail.$elem;
                delete e.detail.$elem;                
                callback($elem, e.detail);

                return false;
            });
        }
    };


    $(document).ready(function($){
        UpUserDatakeeper.init();
        window.UDK = {
            click: UpUserDatakeeper.click
        };
});

})(jQuery);