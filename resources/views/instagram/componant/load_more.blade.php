<div class="col-md-12" id="remove-row">
    <button style=" top:50%; display:block;  margin:0 auto;" type="button"
            class="btn bg-teal-400" id="load_more" onclick="LoadMoreData('{{$limit}}','{{$offset}}')"> Load More
    </button>
</div>

@push('scripts')
    <script>
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                this.LoadMoreData('{{$limit}}', '{{$offset}}')
            }
        });
        function LoadMoreData(limit, offset) {
            $("#load_more").html("Loading....");
            $.ajax({
                url: '{{ url($url) }}' + '/' + limit + '/' + offset,
                method: "GET",
                success: function (data) {
                    $('#remove-row').remove();
                    if (data != '') {
                        $('#data_loaded').append(data);
                    } else {
                        $("#load_more").html("No Data");
                    }
                }
            });

        }
    </script>
@endpush