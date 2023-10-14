var a = 1;
show_right_side = () =>{
    if(a === 1){
        document.querySelector(".right_side").style.display = "block";
        document.querySelector(".fa-bars").className = "fa fa-close";
        document.querySelector(".iframe_page").className = "iframe_page_full";
        return a = 0;
    }
    else{
        document.querySelector(".right_side").style.display = "none";
        document.querySelector(".fa-close").className = "fa fa-bars";
        document.querySelector(".iframe_page_full").className = "iframe_page";
        return a = 1;
    }
}

show_iframe_page = () =>{
    document.querySelector("#home_iframe").style.display = "block";
    document.querySelector("#home_iframe").src = "../";
}

gérer_les_slides = () =>{
    document.querySelector("#home_iframe").src = "./gestionnaire_des_pages/gérer_les_slides.php";
    document.querySelector("#home_iframe").style.display = "block";
}

gérer_les_produits = () =>{
    document.querySelector("#home_iframe").src = "./gestionnaire_des_pages/gérer_les_produits.php";
    document.querySelector("#home_iframe").style.display = "block";
}