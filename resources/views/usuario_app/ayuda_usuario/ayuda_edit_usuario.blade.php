<!--Boton de ayuda-->
    <a href="#buscarusuario" class="btn btn- btn-primary" data-toggle="modal">Ayuda</a>
        <div class="modal fade" id="buscarusuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog"> <!---div class="modal-dialog">-->
                <div class="modal-content"> 
                    <!--header de la ventana-->
                    <div class="modal-header">                    
                        <p class="modal-title"> AYUDA PARA NUEVO ROL</p>
                    </div>
                    <!-- Contenido de la ventana -->
                    <div class="modal-body">
                    <table> 
                        <tr>
                            <td>
                                <img src="{{asset('images/informativo.png')}}" alt="informativo"/>
                            </td>
                            <td>
                                <p> Para realizar la modificaci&oacute;n de usuario usted podrá editar lo siguientes:</p>
                            </td>
                        <tr>    
                            <td>
                                <p><font color="white">...</font></p>
                            </td>
                            <td>
                                <ul>
                                    <li>Nombres: los nombres del usuario.</li>
                                    <li>Apellidos: los apellidos del usuario.</li>
                                    <li>Unidad o departamento al que pertenece el usuario.</li>
                                    <li>Rol: Especifica a que tendra acceso en el sistema.</li>
                                    <li>Correo electr&oacute;nico: muy importante para recuperacion de contrase&ntilde;as.</li>
                                    <li>Cargo: el cargo que desempe&ntilde;a actualmente el usuario.</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p ><font color="white">...</font></p>
                            </td>
                            <td>
                                <p>
                                    Al realizar todos los cambios, debe hacer un clic en el bot&oacute;n "Guardar"<br>
                                    para cancelar los cambios presione "Regresar".
                                </p>
                            </td>
                        </tr>                    
                    </table>  

                    </div>
                    <!--footer de la ventana-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>
<!--FIN Boton de ayuda-->
        