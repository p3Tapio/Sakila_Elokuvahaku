

class NavBar extends React.Component {
    render() {
        return (
            <nav className="navbar navbar-expand-lg navbar-light bg-light">
                <a className="navbar-brand" href="#">Sakila</a>
                <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span className="navbar-toggler-icon"></span>
                </button>
            
                <div className="collapse navbar-collapse" id="navbarColor01">
                <ul className="navbar-nav mr-auto">
                    <li className="nav-item active">
                    <a className="nav-link" href="#">Home <span className="sr-only">(current)</span></a>
                    </li>
                    <li className="nav-item">
                    <a className="nav-link" href="#">Joku</a>
                    </li>
                    <li className="nav-item">
                    <a className="nav-link" href="#">Muu</a>
                    </li>
                    <li className="nav-item">
                    <a className="nav-link" href="#">Alisivu</a>
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