class Genret extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            genre: '',
            recordCount: 0,
            films: [],
            genres: []
        }
    }
    componentDidMount() {
        this.GetGenres(); 
        this.GetFilmsByGenre(); 
    }
    GetGenres() {
        axios.get('/sakila/api/films.php?call=genres')
            .then(res => {
                const genres = res.data; 
                this.setState({ genres });
            })
    }
    handleClickGenre = (event) => {
        
         this.setState({genre: event.target.value}, this.GetFilmsByGenre(event.target.value));
    }
    GetFilmsByGenre(genre) {
    
        if(genre!=="") {
            axios.get('/sakila/api/films.php?call=getgenre&genre='+genre)
                    .then(res => {
                        const films = res.data;
                        const recordCount = res.data.length; 
                        this.setState({ films, recordCount });
                    })
        } 
    }
    render() {
        
        return (
            <div style={{ margin: "auto", width:"50%" }}>
                <div className="form-group" style={{ marginTop:"20px"}}>
                    {this.state.genres.map(genre => 
                        <input type="submit" onClick={this.handleClickGenre} name={genre.name} value={genre.name} className="btn btn-outline-primary btn-sm" style={{marginTop: "5px", textAlign:"center"}}/>
                    )}
                    <hr/>
                    <label>Hakutuloksia: {this.state.recordCount}</label>
                    <div  className = "row" style={{marginLeft: '1rem'}}>
                    {this.state.films.map(film =>
                        <div className= "card border-primary mb-3" style={{maxWidth: "20rem", margin: "5px"}}> 
                        <div className="card-header">{film.release_year} ({film.rating})</div>
                            <div className="card-body">
                                <h4 className="card-title">{film.title}</h4>
                                <p class="card-text">{film.description}</p>
                                </div>
                        </div>
                    )}
                    </div>
                </div>
           </div>
        )
    }
}
