var base_url;
function baseurl(enlace)
{
    base_url = enlace;
}

function pasoUnoSiguiente(){
    $("#personales-tab").removeClass("active");
    $("#complementario-tab").removeClass("active");
    $("#formacion-tab").removeClass("active");
    $("#laboral-tab").removeClass("active");
    $("#cursos-tab").removeClass("active");
    
    $("#complementario-tab").addClass("active");
}
function pasoDosAtras(){
    $("#pasoUno").removeClass("active");
    $("#pasoDosAtras").removeClass("active");
    $("#pasoDosSiguiente").removeClass("active");
    $("#laboral-tab").removeClass("active");
    $("#laboral").removeClass("active");
    $("#cursos-tab").removeClass("active");
    $("#cursos").removeClass("active");
    $("#formacion").removeClass("active");
    $("#formacion-tab").removeClass("active");

    $("#complementario").removeClass("active");
    $("#complementario-tab").removeClass("active");

    $("#personales").addClass("active");
    $("#personales-tab").addClass("active");
}

function pasoDosSiguiente(){
    $("#personales-tab").removeClass("active");
    $("#personales").removeClass("active");
    $("#laboral-tab").removeClass("active");
    $("#laboral").removeClass("active");
    $("#cursos-tab").removeClass("active");
    $("#cursos").removeClass("active");
    $("#complementario").removeClass("active");
    $("#complementario-tab").removeClass("active");
    $("#formacion").addClass("active");
    $("#formacion-tab").addClass("active");
}
function pasoTresAtras(){
    $("#personales-tab").removeClass("active");
    $("#personales").removeClass("active");
    $("#formacion-tab").removeClass("active");
    $("#formacion").removeClass("active");
    $("#laboral-tab").removeClass("active");
    $("#laboral").removeClass("active");
    $("#cursos-tab").removeClass("active");
    $("#cursos").removeClass("active");
    $("#complementario").removeClass("active");
    $("#complementario-tab").addClass("active");
    $("#complementario").addClass("active");
}
function pasoTresSiguiente(){
    $("#formacion-tab").removeClass("active");
    $("#formacion").removeClass("active");
    $("#personales-tab").removeClass("active");
    $("#personales").removeClass("active");
    $("#complementario").removeClass("active");
    $("#complementario-tab").removeClass("active");
    $("#laboral-tab").addClass("active");
    $("#laboral").addClass("active");
}
function pasoCinco()
{
    $("#laboral-tab").addClass("active");
    $("#laboral").addClass("active");
    $("#cursos-tab").removeClass("active");
    $("#cursos").removeClass("active");

    $("#pasoCuatroSiguiente").removeClass("active");
    $("#formacion-tab").removeClass("active");
    $("#formacion").removeClass("active");
    $("#personales-tab").removeClass("active");
    $("#personales").removeClass("active");
    $("#complementario").removeClass("active");
    $("#complementario-tab").removeClass("active");
}
function pasoCuatroAtras(){
    $("#personales-tab").removeClass("active");
    $("#personales").removeClass("active");
    $("#laboral-tab").removeClass("active");
    $("#laboral").removeClass("active");
    $("#cursos-tab").removeClass("active");
    $("#cursos").removeClass("active");
    $("#complementario").removeClass("active");
    $("#complementario-tab").removeClass("active");
    $("#formacion").addClass("active");
    $("#formacion-tab").addClass("active");
}
function pasoCuatroSiguiente(){
    $("#laboral-tab").removeClass("active");
    $("#formacion-tab").removeClass("active");
    $("#personales-tab").removeClass("active");
    $("#formacion").removeClass("active");
    $("#laboral").removeClass("active");
    $("#cursos-tab").addClass("active");
}






