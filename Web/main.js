var updateInterval = 5000; // 5 seconds (ms)
var interval = 900; // 15 minutes (seconds)

$(document).ready(function(){
    updateData();
    setInterval(function() { updateData(); }, updateInterval);
});

function updateData() {
    $.ajax({
        url: "/stats.php?interval=" + interval,
        method: "GET"
    }).success(function(data){
        var totalPeople = 0;
        var totalCurrent = 0;

        $("#summaries").html("");

        for(var zone in data) {
            totalPeople += data[zone].totals.total_in;
            totalCurrent += data[zone].totals.current_count;

            $("#summaries").append(
                "<div class='zone-stat'>" +
                    "<h4 class='title'>" + zone + "</h4>" +
                    "<h1 class='number'>" + data[zone].totals.current_count + "</h1>" +
                    "<span class='unit'>people</span>" +
                "</div>"
            );
        }

        $("#totalIn").html(totalPeople);
        $("#totalCurrent").html(totalCurrent);
    }).error(function(data) {
        alert("Could not get data");
        console.error(data);
    });
}