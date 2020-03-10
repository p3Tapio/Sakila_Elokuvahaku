class HakuNimella extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            films: [],
            recordCount: 0,
            name: ''
        }
    }
    componentDidMount() {
        this.GetFilms(); 
    }
    handleChangeNameInput = (event) => {
        
            if(event.target.value.length>0) {
                this.setState({name: event.target.value}, this.GetFilms(event.target.value));
            } 
            else {
                this.setState({name: ""}, this.GetFilms(event.target.value));
            }
    }
    
    GetFilms(name) {
        
        if(name!=="") {
            axios.get('/sakila/api/films.php?call=name&name='+name)
                    .then(res => {
                        const films = res.data;
                        const recordCount = res.data.length;  
                        this.setState({ films, recordCount });
                    })
        } else {
            this.setState({films: [], recordCount: 0}); 
        }
    }
    render() {
        
        return (
            <div >
                <div style={{margin:"8px"}}>
                    <label for="exampleInputEmail1">Hae elokuvia</label>
                    <input type="text"  onChange={this.handleChangeNameInput} className="form-control inputBox" id="findFilma" placeholder="Hakukenttä"/>
                    <small id="emailHelp" class="form-text text-muted">Voit hakea elokuvia kirjoittamalla elokuvan<br/> nimen tai sen osan hakukenttään</small>
                    <hr/>
                    <label>Hakutuloksia: {this.state.recordCount}</label>
                </div>
                <div className = "row" style={{marginLeft: '0.8rem'}}>
                {this.state.films.map(film =>
                    <div className= "card border-primary mb-3" style={{maxWidth: "20rem", margin: "5px 5px 5px 15px"}}> 
                        <div className="card-header">{film.release_year} ({film.rating})</div>
                            <div className="card-body">
                                <h4 className="card-title">{film.title}</h4>
                                <p class="card-text">{film.description}</p>
                                </div>
                        </div>
                )}
                </div>
            </div>
        )
    }
}
