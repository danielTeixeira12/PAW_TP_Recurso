/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function results(data,id){
    if(data !== ''){
        if(data === 'Eliminado'){
            alert(data);
            document.querySelector('tr[id="'+id+'"]').remove();
        }else{
            alert('Não pode realizar esta acção');
        }
    }else{
        alert('Ocorreu um erro');
    }
}

function eliminarPrestadorAJAX() {  
    var id = this.parentNode.parentNode.getAttribute('id');
    $.get('../Application/Service/EliminarPrestadorService.php', {idPrestador: id},
            function (data) {
                results(data,id);
            }).fail(function () {
                    alert('Ocorreu um erro');
                }
    );
}

function initEvents() {
    var x = document.getElementsByClassName('eliminar');
    var i = 0;
    for (i = 0; i < x.length; ++i) {
        x[i].addEventListener('click', eliminarPrestadorAJAX);
    }
}

document.addEventListener('DOMContentLoaded', initEvents);