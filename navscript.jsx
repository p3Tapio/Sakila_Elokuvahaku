class NavBar extends React.Component {
    render() {
        
        return (
            <nav className="navbar navbar-expand-lg navbar-dark bg-primary">
                <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span className="navbar-toggler-icon"></span>
                </button>   
                <div className="collapse navbar-collapse" id="navbarColor01">
                <ul className="navbar-nav mr-auto">
                    <li className="nav-item" style={{padding: "0.5rem 2rem", display: "block;", color:"white"}}>Sakila</li>
                    <li className="nav-item">
                    <a className="nav-link" href="./hakunimella.php">Haku nimellä<span className="sr-only">(current)</span></a>
                    </li>
                    <li className="nav-item">
                    <a className="nav-link" href="./genret.php">Genret</a>
                    </li>
                </ul>
                </div>
          </nav>
        );
    }
}
ReactDOM.render (
    <NavBar/>,
    document.getElementById("nav")
)
