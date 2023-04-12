import "../css/style.scss"

// Our modules / classes
import MobileMenu from "./modules/MobileMenu"
import HeroSlider from "./modules/HeroSlider"
import GoogleMap from "./modules/GoogleMap"
import Search from "./modules/Search_Axios"
// import MyNotes from "./modules/MyNotes_JQuery"
import MyNotes from "./modules/MyNotes_Axios"

// Instantiate a new object using our modules/classes
const mobileMenu = new MobileMenu();
const heroSlider = new HeroSlider();
const googleMap = new GoogleMap();
const search = new Search();
const myNotes = new MyNotes();
// alert('Hello World 123');