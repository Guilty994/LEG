function getGpus(){
    $.getJSON("./gpu.json", function(lista){
        console.log(lista);
    });
}

function refreshGpus(){
    $.ajax({
        url: "./scriptDaniele.php",
        success: function(){
            getGpus();
        }
    });
}