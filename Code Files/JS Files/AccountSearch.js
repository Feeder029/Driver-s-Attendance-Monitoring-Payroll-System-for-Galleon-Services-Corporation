$(document).ready(function () {
    // Attach listeners to all inputs
    const fetchFilteredData = () => {
        const input = $("#search").val();
        const status = $('input[name="btn"]:checked').val();
        const option = $('input[name="option"]:checked').val();

        $.ajax({
            url: "GetAccount.php",
            method: "POST",
            data: { input: input, status: status, option: option },
            success: function (data) {
                $("#searchresult").html(data);
            },
            error: function (error) {
                console.error("Error fetching accounts:", error);
            }
        });
    };

    // Trigger AJAX on search input
    $("#search").keyup(fetchFilteredData);

    // Trigger AJAX on status change
    $('input[name="btn"]').change(fetchFilteredData);

    // Trigger AJAX on type change
    $('input[name="option"]').change(fetchFilteredData);
});