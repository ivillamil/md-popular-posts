;(function($){

window.MD = window.MD || {};
MD.PopularTabs = {

    init: function() {
        this.cache();
        this.events();
    },

    cache: function() {
        this.widget = $('.MD_Popular_Posts_Widget');
        this.tabs = this.widget.find('[role=tabs]');
    },

    events: function() {
        this.tabs.delegate( 'a[data-content]', 'click', $.proxy(this.changeTabs, this) );
    },

    changeTabs: function( e ) {
        e.preventDefault();

        var el = $(e.target),
            content = el.data('content');

        this.tabs.find('a').removeClass('active');
        el.addClass('active');

        this.widget.find('div[data-content] ul').removeClass('active');
        this.widget.find('div[data-content="'+content+'"] ul').addClass('active');
    }

}

MD.PopularTabs.init();

})(jQuery);