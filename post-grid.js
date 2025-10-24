jQuery(function ($) {

    function loadPosts(options) {
        var button = options.button;
        var page = options.page || 1;
        var widgetId = options.widgetId;
        var pageContent = options.pageContent;
        var filterCat = options.filterCat || '';
        var append = options.append || false;

        $.ajax({
            url: postGridWidget.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_more_posts',
                page: page,
                widget_id: widgetId,
                page_content: pageContent,
                filter_category: filterCat
            },
            beforeSend: function () {
                button.text('Loading...');
            },
            success: function (response) {
                if (response.success) {
                    var container = button.closest('.post-grid-widget').find('.post-grid-container');
                    
                    if (append) {
                        container.append(response.data.html);
                    } else {
                        container.html(response.data.html);
                    }

                    var maxPages = parseInt(response.data.max_pages || button.data('max-pages'));

                    if (page + 1 > maxPages) {
                        button.hide();
                    } else {
                        button.text(response.data.load_more_text);
                        button.data('page', page + 1);
                        button.attr('data-page', page + 1);
                        button.attr('data-max-pages', maxPages);
                        button.show();
                    }
                } else {
                    button.hide();
                }
            }
        });
    }

   // Filter button handler
    $('.post-grid-widget').on('click', '.filter-button', function (e) {
        e.preventDefault();

        var filterButton = $(this);
        $('.filter-button').removeClass('active');
        filterButton.addClass('active');

        var button = $(".post-grid-widget .post-grid-load-more");
        var widgetId = button.data('widget-id');
        var pageContent = button.data('page_content');
        var filterCat = filterButton.data('filter');

        // Reset to page 1
        button.attr('data-page', 1);

        loadPosts({
            button: button,
            page: 1,
            widgetId: widgetId,
            pageContent: pageContent,
            filterCat: filterCat,
            append: false
        });
    });

    // Load More button handler
    $('.post-grid-widget').on('click', '.post-grid-load-more, .post-grid-pagination a', function (e) {
        e.preventDefault();

        var button = $(this);
        var page = parseInt(button.data('page'));
        var widgetId = button.data('widget-id');
        var pageContent = button.data('page_content');
         var filterCat = $('.filter-button.active').attr('data-filter')??'';
        loadPosts({
            button: button,
            page: page,
            widgetId: widgetId,
            pageContent: pageContent,
            filterCat: filterCat,
            append: true
        });
    });



});