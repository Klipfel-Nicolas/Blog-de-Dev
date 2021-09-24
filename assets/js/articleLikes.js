function onClickBtnLike(e){
    e.preventDefault();

    // $this === <a>lien cliquer(e)</a>  
    //href === son lien
    const url = this.href;
    const spanCount = this.querySelector('span.js-likes');
    const icone = this.querySelector('i');

    axios.get(url).then(response =>{
        //on injecte la reponse data de symfony dans le span
        spanCount.textContent = response.data.likes;

        if(icone.classList.contains('fas')) icone.classList.replace('fas', 'far');
        else icone.classList.replace('far', 'fas');
    }).catch(error => {
        if(error.response.status === 403) {
            window.alert("Vous devez vous conecter pour liker.");
        } else {
            window.alert("Une erreur c'est produite, réesayer plus tard.")
        }
    })
}

if(document.querySelector('.js-likes')){
    document.querySelectorAll('a.js-like').forEach(link =>{
    link.addEventListener('click', onClickBtnLike);
})
}

