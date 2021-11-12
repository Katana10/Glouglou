/**
 * ApiContent.js récupère le formulaire de calcul et fait les calcule après un fetch
 * 
 * A la base il faisait 413 lignes et il fonctionnait pas
 * du coup j'ai repris les bases du fichier pour la boucle de calcul principale 
 * 
 * @author TALIBART Killian 
 * @author PARRAGI Thomas
 */

import React from 'react';

const ApiContent = () => {
    /**
     * Zone des Hooks
     * on commence par définir les usestates qui vont pouvoir s'afficher après l'envoie du form
     * 
    */
    const [profondeurs,setProfondeurs] = React.useState([])
    const [temps,setTemps]= React.useState([])
    const [DTR,setDTR]= React.useState('')
    const [DTP,setDTP]= React.useState('')
    const [volumeRemontee,setVolumeRemontee]= React.useState('')
    const [pressionRemontee,setPressionRemontee]= React.useState('')
    const [volumeFin,setVolumeFin]= React.useState('')
    const [pressionFin,setPressionFin]= React.useState('')

    /**
     * Zone des constantes
     */
    var respirationMoyenne = 1/3;               // 20L/min = 1/3 L/s
    var vDescente = 1/3;                        // 20m/min = 1/3 m/s
    var vRemonteAvantPallier = 1/6;             // 10m/min => 1/6m/s
    var vRemonteEntrePallier = 1/10;            // 6m/min => 1/10m/s
    var evolutionBar = 0.1;                     //Le bar évolue de 1/30 toutes les secondes pour une descente de 20m/min
    var bar = 1;                                //bar de l'atmosphère
    var palier = [15,12,9,6,3,0]                //on définit un tableau qui contient les valeurs des palier pour éviter 6 variables

    /**
     * Zone des variables
     */
    //profondeur et palier => on travail en mètre
    let val_profondeur              //rentrer par l'utilisateur
    let val_palier = [];
    let val_id_prof                 //rentrer par l'utilisateur => id de la table de plongée
    //tous les temps => on travail en s mais on donne les résultats en minute
    let val_temps                   //rentrer par l'utilisateur
    let dureeRemonteeP = []
    let temps_av_R
    let temps_descente
    let temps_bas
    let dureeTotale
    let dureeTotaleRemontee = 0     //on est obliger de le définir au début parce que sinon c'est un NaN et il met plein de bug
    //variable pour la bouteille => on travail en Litre et en Bar
    let contenance
    let pressionB                   //rentrer par l'utilisateur
    let volumeB                     //rentrer par l'utilisateur
    let svolumeRemontee
    let spressionRemontee
    let volumeDeFin
    let pressionDeFin
    //variable pour la pression => on travail en bar
    let barMAX
    let barMoyen
    let barP
    //variable pour la consommation //=>on travail en Litre
    let consoRP =[] 
    let consopalier =[]
    let consoD
    let consoPMAX
    let consoRemontee =0    //on est obliger de le définir au début parce que sinon c'est un NaN et il met plein de bug
    
    
    const handleForm = (e) => {
        e.preventDefault();
        // Récupération des informations passées dans le formulaire
        let form = new FormData(document.getElementById("myform"))
        val_profondeur = form.get('prof')   //=> m
        val_id_prof = form.get('id_table')  
        pressionB= form.get('pression')     //=>bar
        volumeB= form.get('volume')         //=>L
        val_temps = form.get('temps')       //=>min
        contenance = volumeB*pressionB      //=>L*Bar
        

        fetch("http://127.0.0.1:8000/api/profondeur/search?search="+val_profondeur+"&id="+val_id_prof)
        .then((result) => result.json())
        .then((result) => {
            //on envoie les infos pour les traiter dans le retour ça permet d'appeler les constantes sans avoir d'erreur
            setProfondeurs(result)
            tempsRechercher(result)
        })
        
    }
    const tempsRechercher = (e) => {
        //on définit juste une variable ici car on l'utilise que là
        //et on pourrait faire sans 
        let val_id_est_a
        
        //on map la réponse qu'on a ramener avec le fetch au dessus pour récupérer l'id et la profondeur
        //pk récupérer encore la profondeur me diré vous et bah si le MR a mis 22 qui n'existe pas l'algo derrière va prendre celle au dessus donc la mofifier
        {(e).map((key) => (
            val_profondeur= key['profondeur'],
            val_id_est_a = key['id'],
            //on calcul par la même occasion des constantes 
            temps_descente = val_profondeur/vDescente,
            //correspond a la pression maximale exercée durant toute la plongée
            barMAX= (bar + evolutionBar * val_profondeur)
            
        ))}
        console.log(temps_descente, val_profondeur,vDescente);
        //on calcul la consommation d'air durant la descente et durant le temps resté en bas car les condition ne sont pas les mêmes
        barMoyen =(bar + barMAX)/2  //=>bar
        temps_bas = val_temps*60 - temps_descente  //=>s
        consoD = respirationMoyenne * temps_descente * barMoyen   //=> L/s * s * bar= L * bar
        consoPMAX = respirationMoyenne * temps_bas * barMAX     //=> L/s * s * bar = L * bar
        //on utilise Math.round pour arrondir 2 chiffres après la virgule
        console.log(temps_bas,val_temps, consoD, consoPMAX);
        svolumeRemontee=Math.round((contenance - (consoD + consoPMAX))*100) / 100 //=> L*Bar 
        spressionRemontee=Math.round((svolumeRemontee/ volumeB)*100)/ 100   //=> L*Bar/L = Bar
        
        fetch("http://127.0.0.1:8000/api/temps/search?search="+val_temps+"&id="+val_id_est_a)
        .then((result) => result.json())
        .then((result) => {
            // console.log(result)
            //on envoie les infos pour les traiter dans le retour ça permet d'appeler les constantes sans avoir d'erreur
            setVolumeRemontee(svolumeRemontee)
            setPressionRemontee(spressionRemontee)
            setTemps(result)
            calcul(result)
        })
        
    }
    
    //a partir de cette fonction j'étais tellement fatigué que quand ça fonctionnait j'ai pas chercher pourquoi
    const calcul = (e)=> {
        {(e).map((key) => (
            temps_av_R = key['temps']*60, //=>s = min*60
            val_palier[0] =  key['palier15']*60, //=>s = min*60
            val_palier[1] =  key['palier12']*60, //=>s = min*60
            val_palier[2] =  key['palier9']*60, //=>s = min*60
            val_palier[3] =  key['palier6']*60, //=>s = min*60
            val_palier[4] =  key['palier3']*60 //=>s = min*60
        ))}
        
        //on parcours une boucle qui va regarder chaque palier possède une valeur
        for (let i=0;i<6;i++){
            //là on s'assure de ne pas avoir de problème pour la suite en mettant une valeur au lieu de rien
            if(dureeRemonteeP[i]===undefined){
                dureeRemonteeP[i]=0
            }
            if(consoRP[i]===undefined){
                consoRP[i]=0  
            }
            //ici on vérifie qu'il y'a une valeur au palier (un temps d'arrêt) ou qu'on soit au niveau de la surface
            if ((val_palier[i]!==0) || (palier[i]===0)){
                //comme on a pas de valeur pour le palier 0 (vue qu'on peut respirer directement) on assigne 0
                if(palier[i]===0){
                    val_palier[i]=0
                }
                //on vérifie qu'on ne soit pas remontée
                if (dureeRemonteeP[i-1]===0){
                    //si c'est pas le cas on calcule avec la vitesse de remontée avant palier
                    dureeRemonteeP[i]= (val_profondeur - palier[i])/vRemonteAvantPallier    //=> (m -m)/(m/s) =s
                }else{
                    //si c'est le cas on est donc déja à un pallier donc on remonte avc la vitesse inter-palier
                    dureeRemonteeP[i]= (palier[i-1] - palier[i])/vRemonteEntrePallier   //=> (m -m)/(m/s) =s
                }
                //la on calcule la pression au palier et entre le palier 
                barP = Math.round((bar + evolutionBar * palier[i])*100) / 100   //=> Bar 
                barMoyen = Math.round(((barMAX -barP)/2)*100) / 100             //=> Bar
                consoRP[i] = respirationMoyenne *dureeRemonteeP[i] *barMoyen    //=> L/s * s * Bar = L*Bar
                consopalier[i] = respirationMoyenne *val_palier[i] *barMoyen    //=> L/s * s * Bar = L*Bar
                
                //on vérifie que le code avant est bien fonctionner (ON EST JAMAIS TROP PRUDENT)
                if ((dureeRemonteeP[i]!==null) || (dureeRemonteeP[i]!==undefined)){
                    //on fait la sommes du temps de remontée entre les paliers et du temps sur chaque palier pour avoir le temps total de la remontée
                    dureeTotaleRemontee+=(dureeRemonteeP[i]+ val_palier[i])

                }
                //on vérifie que le code avant est bien fonctionner (ON EST JAMAIS TROP PRUDENT)
                if ((consoRP[i]!==null) || (consoRP[i]!==undefined)){
                    //on fait la sommes de la consommation de la remontée et de la conso sur le palier
                    consoRemontee+=(consoRP[i]+consopalier[i])
                }

                    
               
            }      
        }
        //on calcule enfin les valeurs finale que l'on va renvoyer 
        volumeDeFin = Math.round((svolumeRemontee - consoRemontee)*100)/100
        pressionDeFin = Math.round((volumeDeFin/volumeB)*100)/100
        dureeTotale = Math.round(((temps_av_R + dureeTotaleRemontee)/60)*100)/100
        //alors la on fait un fetch qui va vers une adresse de l'api mais c'est pas important comme on traite pas les résultats
        //c'est juste qu'il faut une adresse dedans donc on en met une
        fetch("http://127.0.0.1:8000/api/temps/search?search=1&id=1")
        .then(() => {
            //on divise la durée par 60 pour la remettre en minute
            setDTR(dureeTotaleRemontee/60)
            setDTP(dureeTotale)
            setVolumeFin(volumeDeFin)
            setPressionFin(pressionDeFin)
        })  
    }
    return(
        <main className="content">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossOrigin="anonymous"></link>
            <form action="/" method="GET" id="myform" onSubmit={handleForm}>
                Table de plongée:   
                <select class="form-control" name="id_table">
                    <option value="Buhlman">Buhlman</option>
                    <option value="MN90">MN90</option>
                </select><br/>
                Profondeur: <input class="form-control" type="number" name="prof"/> m<br/> 
                Temps avant remontée: <input class="form-control" type="number" name="temps"/>  min<br/>
                Pression de la bouteille : <input class="form-control" type="number" name="pression" defaultValue="200"/> bar <br/>
                Volume de la bouteille :
                <select class="form-control" name="volume">
                    <option value="9">9</option>
                    <option value="12">12</option>
                    <option value="15">15</option>
                    <option value="18">18</option>
                </select> L<br/>
                <input type="submit"/>
            </form>
            <div>
                {profondeurs.map((profondeurs, id) => {
                    return <p key={id}>Profondeur:{profondeurs.profondeur}</p>
                })}
            </div>
            <div>
                {temps.map((temps, id) => {
                    return <div key={id}>
                        Temps:{temps.temps} min<br/>
                        Palier 15:{temps.palier15} min<br/>
                        Palier 12:{temps.palier12} min<br/>
                        Palier 9:{temps.palier9} min<br/>
                        Palier 6:{temps.palier6} min<br/>
                        Palier 3:{temps.palier3} min<br/>
                        <p>
                        Volume Avant la remontée:{volumeRemontee} L<br/>
                        Pression Avant la remontée:{pressionRemontee} Bar<br/>
                        Durée Totale Remontée:{DTR} Min<br/>
                        Durée Totale Plongée:{DTP} Min<br/>
                        Volume de fin:{volumeFin} L<br/>
                        Pression de fin:{pressionFin} Bar<br/>
                        </p>
                        </div>
                        
                })}
            </div>
            
            
        </main>
    )
}

export default ApiContent;