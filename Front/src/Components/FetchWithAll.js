/**
 * FetchWithAll.js fait un fetch pour récupérer toutes les infos contenuent dans la BDD
 * 
 * J'estime que comme il est moins complet que ApiContent et que un bout de code est le même 
 * il n'est pas nécessaire de le commenté
 * 
 * @author TALIBART Killian 
 * 
*/

import React from 'react';


const FetchWithAll = ({ text }) => {
    const [profondeurs, setProfondeur] = React.useState([]);

    React.useEffect(() => {
        setTimeout(() => {
            fetch("http://127.0.0.1:8000/api/all/look")
            .then((res) => res.json())
            .then((res) => setProfondeur(res));
        }, 1000);
    }, []);
    
    return (
    <div>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossOrigin="anonymous"></link>
        
        {Object.keys(profondeurs).map((key) => (
            <div className="tableaux">
            <table className="table table-striped table-dark">
                <caption className="test">{key}</caption>
                <thead>
                    <tr>
                        {/* <th scope="col">Id</th> */}
                        <th scope="col">Temps</th>
                        <th scope="col">Pallier15</th>
                        <th scope="col">Pallier12</th>
                        <th scope="col">Pallier9</th>
                        <th scope="col">Pallier6</th>
                        <th scope="col">Pallier3</th>
                        <th scope="col">Profondeur</th>
                    </tr>
                </thead>
                <tbody>
                    {profondeurs[key].map((profondeurss) => (
                        
                            profondeurss.map((temps) => (
                                <tr>
                                {/* <td>{temps['id']}</td> */}
                                <td>{temps['temps']}</td>
                                <td>{temps['palier15']}</td>
                                <td>{temps['palier12']}</td>
                                <td>{temps['palier9']}</td>
                                <td>{temps['palier6']}</td>
                                <td>{temps['palier3']}</td>
                                <td>{temps['est_a']['profondeur']}</td>
                                </tr> 
                            ))  
                    ))}
                </tbody> 
            </table>
            </div>
        ))}  
    </div>
    );
    
};

export default FetchWithAll;