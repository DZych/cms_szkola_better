function weryfikujHasło() {  
    var  pw  =  dokument .getElementById("password1").value;  
    var pw2 = dokument .getElementById("password2").value;  
    //sprawdź puste pole hasła  
    if( pw  == "") {  
      alert("**Proszę podać hasło!" );        
       return false;  
    }  
     
   //Weryfikacja minimalnej długości hasła  
    if(pw.długość  < 8 ) {   
      alert("**Długość hasła musi wynosić co najmniej 8 znaków" );     
       return false;  
    }
    if (pw != pw2){
      alert("Hasła nie są takie same") ;
    }  
    
  //maksymalna długość walidacji hasła  
    if(pw.długość  >  15) {  
       alert("**Długość hasła nie może przekraczać 15 znaków" );  
       return false;  
    }else {  
       alert("Hasło jest poprawne");  
    }
      
  }  