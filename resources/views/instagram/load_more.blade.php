<div class="col-md-12" id="remove-row">
    <button data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> loading.... " type="button" class="btn btn-primary" id="load_more" onclick="LoadMoreData()"> Load More
    </button>
</div>

@push('js')
    <script>
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                this.LoadMoreData();
            }
        });
        function LoadMoreData() {
            var loadMoreBtn = $("#load_more");
            loadMoreBtn.button('loading');
            $.ajax({
                url: "{{url('instagram-user-pagination')}}",
                method: "GET",
                success: function (data) {
                    if (data != '') {
                        $('#data_loaded').append(data);
                        setTimeout(function () {
                            loadMoreBtn.button('reset');
                        });
                    } else {
                        setTimeout(function () {
                            loadMoreBtn.button('reset');
                        }, 0);
                       loadMoreBtn.attr('disabled','disabled')
                        $('#remove-row').hide();
                    }
                }
            });
        }
    </script>
@endpush