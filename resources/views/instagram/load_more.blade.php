<div class="col-md-12" id="remove-row">
    <button data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> loading.... " type="button" class="btn btn-primary" id="load_more" onclick="LoadMoreData()"> Load More
    </button>
</div>

@push('js')
    <script>
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
                        $("#load_more").html("No Data");
                        setTimeout(function () {
                            loadMoreBtn.button('reset');
                        }, 0);
                    }
                }
            });
        }
    </script>
@endpush