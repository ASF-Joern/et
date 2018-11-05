<script>
    var attribute=$(".attribute<-OrderID->").html().split("<br>");
    if(attribute.length >= 5){
        var ring=attribute.shift().split(" ");
        for(var i in attribute){
            $("#zertModel<-OrderID->").text(ring[1]);
            $("#zertMaterial<-OrderID->").text(ring[2]+" "+ring[3])):($("#zertModel<-OrderID").text(ring[1]+" "+ring[2]),$("#zertMaterial<-OrderID").text(ring[3]+" "+ring[4])),attribute){var parts=attribute[i].split(":");if("Steinbesatz Damenring"===parts[0]||"Steinbesatz"===parts[0]){var patt=new RegExp("Brillant");if(patt.test(parts[1])){(console.log("Brillant"),$("#zertWeight<-OrderID->").text(String(parts[1]).replace("Brillant","")))}patt=new RegExp("Princessschliff");if(patt.test(parts[1])){(console.log("Princess"),$("#zertWeight<-OrderID->").text(String(parts[1]).replace("Princessschliff","")),$("#zertRefinement<-OrderID->").text("Princess"))}}}}$("br").each(function(){$(this).remove()}),$("head style").remove();</script>