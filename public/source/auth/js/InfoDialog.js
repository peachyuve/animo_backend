class InfoDialog {
  constructor(id){
    this.box = document.getElementById(id);
    this.backdrop = document.getElementById("dialog-backdrop")
    this.close = document.getElementById("dialog-close")
    this.backdrop.addEventListener('click',()=>this.hidePopup())
    this.close.addEventListener('click',()=>this.hidePopup())
  }
  showPopup(){
    this.backdrop.style.opacity = 1;
    this.backdrop.style.visibility = 'visible';
    this.box.style.opacity = 1;
    this.box.style.visibility = 'visible';
  }
  hidePopup(){
    this.backdrop.style.opacity = 0;
    this.backdrop.style.visibility = 'hidden';
    this.box.style.opacity = 0;
    this.box.style.visibility = 'hidden';
  }
}