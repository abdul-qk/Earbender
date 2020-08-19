    <script>
        $('#myTab a').on('click', function(e) {
            e.preventDefault()
            $(this).tab('show')
        })

        $(function() {
            $('.selectpicker').selectpicker();
        });
    </script>

</body>

</html>