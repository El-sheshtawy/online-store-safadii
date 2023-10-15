@section('ajax_script')
    <script>
        $(document).ready(function () {

            //Ajax search
            $(document).on('keyup', function (e) {
                e.preventDefault();
                let search_string = $("#search").val();
                console.log(search_string);
                $.ajax({
                    url: "{{ route('admin.roles.search') }}",
                    method: 'GET',
                    data: {search_string: search_string},
                    success: function (res) {
                        $('.roles-table').html(res);
                    },
                    error: function (e) {
                        console.log(e);
                    },
                });
            });


            //Ajax paginate
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                role(page);
            });
            function role(page) {
                $.ajax({
                    url:"/admin/dashboard/roles-pagination?page="+page,
                    method: 'GET',
                    success: function (res) {
                        $('.roles-table').html(res);
                    },
                    error: function (e) {
                        console.log(e);
                    }
                })
            }
        });
    </script>
@endsection
