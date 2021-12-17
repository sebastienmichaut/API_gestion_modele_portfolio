<?php
include "header.php";
session_start();
//  TEST SUR LA LIGNE 56 POUR ALLER DANS LE COMPTE RENDU SUR compteRenduIntervention1.php
?>
        <div class="row justify-content-center mt-3">
            <h4><b><u>PLANNING HEBDOMADAIRE des DISPONIBILITES technicien - fenetre 1</u></b></h4>            
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Nom du technicien</span>
                </div>
                <input type="text" class="form-control col-3 ml-2 mr-5" aria-label="Nom_tech" aria-describedby="basic-addon1" value="<?= $_SESSION['prenom_technicien'] . " " . $_SESSION['nom_technicien'] ?>">   <!-- Affichage du prenom et du nom du technicien -->
                <div class="input-group-prepend ml-5">
                    <span class="input-group-text" id="basic-addon1">Semaine du</span>
                </div>
                <input type="text" class="form-control col-1 ml-4 mr-2" aria-label="Username" aria-describedby="basic-addon1"><span>au</span>
                <input type="text" class="form-control col-1 mx-2" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Département</span>
                    </div>
                    <input type="text" class="form-control col-1 mx-2" aria-label="Username" aria-describedby="basic-addon1">
                    <div class="input-group-prepend">
                        <span class="input-group-text ml-5" id="basic-addon1">sous-zone</span>
                    </div>
                    <input type="text" class="form-control col-4 mx-2" aria-label="Username" aria-describedby="basic-addon1">                    
                </div>              
            </div>
            <table class="table table-bordered mt-5">
                <thead>
                    <tr>
                        <th scope="col" class="border border-secondary"></th>
                        <th scope="col" class="border border-secondary text-center">Lundi</th>
                        <th scope="col" class="border border-secondary text-center">Mardi</th>
                        <th scope="col" class="border border-secondary text-center">Mercredi</th>
                        <th scope="col" class="border border-secondary text-center">Jeudi</th>
                        <th scope="col" class="border border-secondary text-center">Vendredi</th>
                        <th scope="col" class="border border-secondary text-center">Samedi</th>
                        <th scope="col" class="border border-secondary text-center">Dimanche</th>                                                                                                
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" class="border border-secondary">6H à 7H</th>
                        <td class="border border-secondary">
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-secondary px-2 mb-1">Journée</button>                                                           
                            </div>
                            <!-- ZONE DE TEST EN ATTENDANT QUE LE ZONAGE DES RDV SOIT FAIT DANS LE PLANNING -->
                            <!-- <form action="compteRenduIntervention1.php" method="get">
                                <div class="d-flex justify-content-center">
                                    <input type="submit" class="btn btn-success px-4" name="id_rdv" value="1">
                        </td>
                        <td class="border border-secondary">
                                <div class="d-flex justify-content-center">
                                    <input type="submit" class="btn btn-success px-4" name="id_rdv" value="2">
                                </div>  
                            </form> -->
                        </td>
                            <!-- FIN DE ZONE DE TEST -->
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td>                                              
                    </tr>
                    <tr>
                        <th scope="row" class="border border-secondary">7H à 8H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr>
                    <tr>
                        <th scope="row" class="border border-secondary">8H à 9H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr>
                    <tr>
                        <th scope="row" class="border border-secondary">9H à 10H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr>
                    <tr>
                        <th scope="row" class="border border-secondary">10H à 11H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr>
                    <tr>
                        <th scope="row" class="border border-secondary">11H à 12H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr>
                    <tr>
                        <th scope="row" class="border border-secondary">12H à 13H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr>
                    <tr>
                        <th scope="row" class="border border-secondary">13H à 14H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr>
                    <tr>
                        <th scope="row" class="border border-secondary">14H à 15H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr> 
                    <tr>
                        <th scope="row" class="border border-secondary">15H à 16H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr> 
                    <tr>
                        <th scope="row" class="border border-secondary">16H à 17H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td>  
                    </tr> 
                    <tr>
                        <th scope="row" class="border border-secondary">17H à 18H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr> 
                    <tr>
                        <th scope="row" class="border border-secondary">18H à 19H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr> 
                    <tr>
                        <th scope="row" class="border border-secondary">19H à 20H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr>
                    <tr>
                        <th scope="row" class="border border-secondary">20H à 21H</th>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>
                        <td class="border border-secondary"></td>  
                        <td class="border border-secondary"></td> 
                    </tr>                                                                                                                                                                                                                                                                       
                </tbody>
            </table>
        </div>
    </div>

<?php
include "./footer.php";
?>