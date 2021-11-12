/**
 * FetchWithEffect.js fait un fetch pour récupérer les infos des profondeurs de chaque table
 * 
 * J'estime que comme il est moins complet que ApiContent et que un bout de code est le même 
 * il n'est pas nécessaire de le commenté
 * 
 * @author TALIBART Killian 
 * 
 */
import React from 'react';


const FetchWithEffect = ({ text }) => {
    const [profondeurs, setProfondeur] = React.useState([]);
    React.useEffect(() => {
        setTimeout(() => {
            fetch("http://127.0.0.1:8000/api/profondeur/look")
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
                            <th scope="col">Profondeur</th>
                        </tr>
                    </thead>
                    <tbody>
                        {profondeurs[key].map((profondeur) => (
                            <tr>
                                {/* <td>{profondeur.id}</td> */}
                                <td>{profondeur.profondeur}</td>
                            </tr> 
                        ))}
                    </tbody> 
                </table>
            </div>
          ))
        }
        
    </div>
    );
    
};

export default FetchWithEffect;