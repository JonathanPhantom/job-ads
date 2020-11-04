document.getElementById("yes").addEventListener("click", function () {
    document.querySelector(".disponible").classList.remove("active");
    document.getElementById("now").checked = true;

});

document.getElementById("no").addEventListener("click", function () {
    document.querySelector(".disponible").classList.add("active");
});

function disableDateDisponible(id) {

    notYet = document.getElementById(id);
    if (notYet.checked)
        document.querySelector("#dateDisponibilite").disabled = false;
    else
        document.querySelector("#dateDisponibilite").disabled = true;

}
select =  document.getElementById('compte_candidat_disponibilite');
select.addEventListener("select", ()=>{
    if (select.value === 0){
        alert(0)
    }
})