    $("body").on("click", '.swal2-link', function (event) {
        event.preventDefault();
        console.log('truc');
        let title = $(this).attr("swal2-title");
        let text = $(this).attr("swal2-title");
        let link = $(this).attr("href");
        warningswal2(title, text, link);
    });

    function warningswal2(title="", text="", link="") {
        Swal.fire({
            title: title,
            html: text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        });
    }