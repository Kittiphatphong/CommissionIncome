// Class definition
var KTQuilDemos = function() {

    // Private functions
    var demo1 = function() {
        var quill = new Quill('#texareaJ', {
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block']
                ]
            },
            placeholder: 'Type your text here...',
            theme: 'snow' // or 'bubble'
        });
    }



    return {
        // public functions
        init: function() {
            demo1();

        }
    };
}();

jQuery(document).ready(function() {
    KTQuilDemos.init();
});
