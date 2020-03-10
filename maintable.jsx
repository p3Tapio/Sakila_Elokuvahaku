// TODO: tallennuksen tulos modaliin tms tai ainakin forward takaisin kaikki elokuvat tauluun 

class MainTable extends React.Component {

    constructor(props) {

        super(props);
        this.state = { render: 'AllFilms', btnText: 'Lisää uusi', otsikko: 'Sakila tietokannan elokuvat' };
        this.toggleRender = this.toggleRender.bind(this);
    }
    toggleRender() {
        const newText = this.state.btnText == 'Lisää uusi' ? 'Kaikki elokuvat' : 'Lisää uusi';
        const newRender = this.state.render == 'AllFilms' ? 'LisaaElokuva' : 'AllFilms';
        const newOtsikko = this.state.otsikko == 'Sakila tietokannan elokuvat' ? 'Lisää uusi elokuva' : 'Sakila tietokannan elokuvat';
        this.setState({ btnText: newText, render: newRender, otsikko: newOtsikko });
    }
    render() {

        let toRender;
        if (this.state.render === 'LisaaElokuva') toRender = <LisaaElokuva />;
        else toRender = <AllFilms />;

        return (
            <div>
                <br />
                <div style={{ margin: "8px" }}>
                    <h4>{this.state.otsikko}</h4>
                    <button onClick={this.toggleRender} className="btn btn-outline-primary">{this.state.btnText}</button><br />
                </div>
                <hr />
                {toRender}
            </div>
        )
    }
}

class LisaaElokuva extends React.Component {
    constructor(props) {
        super(props);
        this.state = { 
            kielet: [],
            nimi: "", kuvaus: "", vuosi: "", kieli: "", aika:"", vuokrahinta:"", pituus:"", korvaushinta:"", 
            features: [],
            response: ''   
         };
         this.handleInputChange = this.handleInputChange.bind(this); 
         this.handleSubmit = this.handleSubmit.bind(this); 
    }
    componentDidMount() {
        this.getKielet();
    }
    handleInputChange (event) {
        if(event.target.id!=="features") {
           this.setState({ [event.target.id]:event.target.value });   
        } else {
           let value = Array.from(event.target.selectedOptions, option => option.value); 
           this.setState({features:value}); 
        }
    }
    handleSubmit(event) {      
        event.preventDefault(); 
        this.setFilm(); 
    }
    getKielet() {
        axios.get('/sakila/api/films.php?call=kielet')
            .then(res => {
                const kielet = res.data;
                this.setState({ kielet });
            })
    }
    setFilm() {
        const film = {
            nimi: this.state.nimi,
            kuvaus: this.state.kuvaus,
            vuosi: this.state.vuosi,
            kieli: this.state.kieli, 
            aika: this.state.aika, 
            vuokrahinta: this.state.vuokrahinta, 
            pituus: this.state.pituus, 
            korvaushinta: this.state.korvaushinta,
            features: this.state.features
        }
        const filmJson = JSON.stringify(film); 

        axios({
            method: 'post',
            url: '/sakila/api/films.php?call=setfilm',
            data: filmJson,
            config: { headers: {'Content-Type': 'application/json' }}
        }).then(res => {
            console.log(res.data); 
            this.setState({response : res.data}); 
            alert(this.state.response); 
        });
    }   
    render() {
        return (
            <div>
                <form method="POST" onSubmit={this.handleSubmit}>
                    <div class="form-group" style={{ width: "240px", margin: "8px" }}>
                        <input type="text" onChange ={this.handleInputChange} className="form-control" id="nimi" placeholder="Nimi" />
                        <textarea type="text"  onChange ={this.handleInputChange} className="form-control" id="kuvaus" rows="3" placeholder="Kuvaus"></textarea>
                        <input type="text" onChange ={this.handleInputChange} id="julkaisuvuosi" className="form-control" placeholder="Julkaisuvuosi" />
                        <select onChange={this.handleInputChange} className="form-control" id="kieli">
                            <option selected="kieli">Kieli</option>
                                {this.state.kielet.map(kieli =>
                                    <option key={kieli.language_id} value={kieli.language_id}>{kieli.name}</option>
                                )}
                        </select>
                        <input type="text" onChange ={this.handleInputChange} id="vuokra-aika" className="form-control" placeholder="Vuokra-aika"/>
                        <input type="text" onChange ={this.handleInputChange} id="vuokrahinta" className="form-control" placeholder="Vuokrahinta"/>
                        <input type="text" onChange ={this.handleInputChange} id="pituus" className="form-control" placeholder="Pituus"/>
                        <input type="text" onChange ={this.handleInputChange} id="korvaushinta" className="form-control" placeholder="Korvaushinta"/>
                        <select onChange={this.handleInputChange} className="form-control" id="features" multiple>
                            <option value="Deleted Scenes">Deleted Scenes</option>
                            <option value="Behind the Scenes">Behind the Scenes</option>
                            <option value="Commentaries">Commentaries</option>
                            <option value="Trailers">Trailers</option>
                        </select>
                        <input type="submit" name="submit" className="btn btn-outline-primary" value="Tallenna" style={{margin:"5px"}}/>
                        <input type="reset" className="btn btn-outline-danger" value="Tyhjennä"/>  
                    </div>
                </form>
            </div>
        )
    }
}
class AllFilms extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            films: [],
            recordCount: 0,
            start: 0,
            end: 15
        }
    }
    componentDidMount() {
        this.GetAllFilms();
    }
    handleClickNext = () => {
        let newStart = this.state.start + 15;
        if (newStart > this.state.recordCount - 15) newStart = this.state.recordCount - 15;
        this.setState({ start: newStart }, this.GetAllFilms(newStart));
    }
    handleClickPrev = () => {
        let newStart = this.state.start - 15;
        if (newStart < 0) newStart = 0;
        this.setState({ start: newStart }, this.GetAllFilms(newStart));
    }
    GetAllFilms(start) {
        if (start === undefined) start = this.state.start;
        axios.get('/sakila/api/films.php?call=all')
            .then(res => {
                const recordCount = res.data.length;
                this.setState({ recordCount });
            })
        axios.get('/sakila/api/films.php?call=all&start=' + start + '&end=' + this.state.end)
            .then(res => {
                const films = res.data;
                this.setState({ films });
            })
    }
    render() {
        return (
            <div>
                <table className="table table-hover ">
                    <thead className="table-primary">
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Release year</th>
                            <th scope="col">Language</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Length</th>
                            <th scope="col">Speacial features</th>
                        </tr>
                    </thead>
                    <tbody>
                        {this.state.films.map(film =>
                            <tr>
                                <td>{film.title}</td>
                                <td>{film.release_year}</td>
                                <td>{film.name}</td>
                                <td>{film.rating}</td>
                                <td>{film.length} min</td>
                                <td>{film.special_features}</td>
                            </tr>
                        )}
                    </tbody>
                </table>
                <hr />
                <div style={{ textAlign: "center" }}>
                    <button onClick={this.handleClickPrev} className="btn btn-outline-primary btn-lg">Prev</button>
                    <button onClick={this.handleClickNext} className="btn btn-outline-primary btn-lg">Next</button>
                </div>
            </div>
        )
    }

}


// setFilm() {
//     const film = {
//         nimi: this.state.nimi,
//         kuvaus: this.state.kuvaus,
//         vuosi: this.state.vuosi,
//         kieli: this.state.kieli, 
//         aika: this.state.aika, 
//         vuokrahinta: this.state.vuokrahinta, 
//         pituus: this.state.pituus, 
//         korvaushinta: this.state.korvaushinta,
//         features: this.state.features
//     }
//     const filmJson = JSON.stringify(film); 
// //    console.log("FilmJson: " + filmJson); 

//     axios.post('/sakila/api/films.php?call=setfilm', {filmJson}) 
//         .then(res => {
//             console.log("Axios res:" +res);
//             console.log("Axios res.data:" +res.data); 
//         });
// }
