<div class="col-md-12" id="remove-row">
    <button type="button" class="btn bg-teal-400" id="load_more" onclick="LoadMoreData()"> Load More
    </button>
</div>

@push('js')
    <script>
        function LoadMoreData() {
            var page = 1;
            page++;
            $("#load_more").html("Loading....");
            $.ajax({
                url: "{{url('instagram-user-pagination')}}",
                method: "GET",
               // headers: {"Accept": 'text/html'},
                success: function (data) {
                    //$('#remove-row').remove();
                    console.log(data);
                    if (data != '') {
                        $('#data_loaded').append(data);
                    } else {
                        $("#load_more").html("No Data");
                    }
                }
            });
            $("#load_more").html("Load More");
        }
    </script>
@endpush