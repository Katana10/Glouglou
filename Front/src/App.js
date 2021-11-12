/**
 * App.js sert de page de garde permet d'organiser en gros
 *   
 * @author PARRAGI Thomas
 * 
 */
import './App.css';

// Thirds services
import {
  Link,
  Route,
  BrowserRouter as Router,
  Switch
} from "react-router-dom";

import Aside from './Components/Aside'
import ApiContent from './Components/ApiContent'
import FetchWithEffect from './Components/FetchWithEffect';
import React from 'react';




function App() {
  return (
    <Router>
    <div className="App">
      <header className="App-header">
        <p>Bienvenue sur GlouGlou, préparez vos bouteilles</p>
        <nav>
            <ul>
              <li><Link to="/">Home</Link></li>
              <li><Link to="/profondeur">Profondeur</Link></li>
              <li><Link to="/formulaire">Formulaire de calcul</Link></li>
            </ul>
          </nav>
      </header>
      <div>

        <Switch>
          <Route exact path="/"> <Aside/> </Route>
          <Route path="/profondeur"> <FetchWithEffect/> </Route>
          <Route path="/formulaire"> <ApiContent /> </Route>
        </Switch>

      </div>
    </div>
    <footer className="App-footer">
      Vous pouvez aller barbotter en toute sécurité avec GlouGlou
    </footer>
    </Router>
    
  );
}

export default App;
