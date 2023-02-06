// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyDhSTKWpQsmZcR9i8nx6a-SJdC2j4K7OBs",
  authDomain: "rm-delivery-1536a.firebaseapp.com",
  projectId: "rm-delivery-1536a",
  storageBucket: "rm-delivery-1536a.appspot.com",
  messagingSenderId: "623103770562",
  appId: "1:623103770562:web:d98832f1ee5570ca6de05b"
};

// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.16.0/firebase-app.js";
import { getAuth, onAuthStateChanged, signInWithEmailAndPassword, createUserWithEmailAndPassword, signInWithPopup, GoogleAuthProvider, FacebookAuthProvider  } from "https://www.gstatic.com/firebasejs/9.16.0/firebase-auth.js";
import { getFirestore, collection, doc, addDoc, setDoc, getDocs, query, where } from "https://www.gstatic.com/firebasejs/9.16.0/firebase-firestore.js"; 

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize Firebase Authentication and get a reference to the service
const auth = getAuth(app); 

$("#user_name").focus(function(){
    $("#user_name").removeClass('border border-danger');
    $("#alert").hide();
});
$("#user_email").focus(function(){
    $("#user_email").removeClass('border border-danger');
    $("#alert").hide();
});
$("#user_password").focus(function(){
    $("#user_password").removeClass('border border-danger');
    $("#alert").hide();
});
$("#user_rpassword").focus(function(){
    $("#user_rpassword").removeClass('border border-danger');
    $("#alert").hide();
});

$("#register").click(function(){
    var name       = $("#user_name").val();
    var email       = $("#user_email").val();
    var password    = $("#user_password").val();
    var rpassword    = $("#user_rpassword").val();
    var docData;

    if(name!="" && email!="" && password!="" && rpassword!=""){
        createUserWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
            // Signed in 
            const user = userCredential.user;
            var uid = user.uid;

            const docData = {
                user_name: userCredential.user.displayName,
                user_email: userCredential.user.email,
                user_phone: userCredential.user.phoneNumber,
                user_urlphoto: userCredential.user.photoURL,
                user_order_notify: true,
                user_order_email: true,
                user_order_message: true,
                user_info_notify: true,
                user_info_email: true,
                user_info_message: true
            };
            
            const db = getFirestore(app);

            const userRef =   doc(db, "users", uid); 
            setDoc(userRef, docData, { merge:true })
            .then(userRef => {
                console.log("Document Field has been updated successfully");
                window.location = "../Home.html";
            })
            .catch(error => {
                console.log(error);
            })
            /*
            // Add a new document with a generated id.
            const docRef = addDoc(collection(db, "users", userCredential.user.uid), docData).then((ret) => {
                window.location = "../Home.html";
            });
            */  
        })
        .catch((error) => {
            const errorCode = error.code;
            const errorMessage = error.message;
            
            //if(errorMessage.indexOf("auth/user-not-found") != -1){ 
                $("#alert").html(errorMessage);
                $("#alert").show();
            //}
        });

    }else{
        if(name=="") $("#user_name").addClass('border border-danger');
        if(email=="") $("#user_email").addClass('border border-danger');
        if(password=="") $("#user_password").addClass('border border-danger');
        if(rpassword=="") $("#user_rpassword").addClass('border border-danger');
    }
});

$("#loginWithGoogle").click(function(){
    const provider = new GoogleAuthProvider();

    signInWithPopup(auth, provider)
    .then((result) => {
        // This gives you a Google Access Token. You can use it to access the Google API.
        const credential = GoogleAuthProvider.credentialFromResult(result);
        const token = credential.accessToken;
        // The signed-in user info.
        const user = result.user;
        var uid = user.uid;
        
        const docData = {
            user_name: result.user.displayName,
            user_email: result.user.email,
            user_phone: result.user.phoneNumber,
            user_urlphoto: result.user.photoURL,
            user_order_notify: true,
            user_order_email: true,
            user_order_message: true,
            user_info_notify: true,
            user_info_email: true,
            user_info_message: true
        };

        const db = getFirestore(app);

        const userRef =   doc(db, "users", uid); 
        setDoc(userRef, docData, { merge:true })
        .then(userRef => {
            console.log("Document Field has been updated successfully");
            window.location = "../Home.html";
        })
        .catch(error => {
            console.log(error);
        })
        /*
        // Add a new document with a generated id.
        const docRef = addDoc(collection(db, "users", result.user.uid), docData).then((ret) => {
            window.location = "../Home.html";
        });
        */
    }).catch((error) => {
        // Handle Errors here.
        const errorCode = error.code;
        const errorMessage = error.message;
        // The email of the user's account used.
        const email = error.customData.email;
        // The AuthCredential type that was used.
        const credential = GoogleAuthProvider.credentialFromError(error);
        
        $("#alert").html("Usuário não encontrado!");
        $("#alert").show();
    });
});

$("#loginWithFacebook").click(function(){
    const provider = new FacebookAuthProvider();

    signInWithPopup(auth, provider)
    .then((result) => {
        // The signed-in user info.
        const user = result.user;
        var uid = user.uid;
        // This gives you a Facebook Access Token. You can use it to access the Facebook API.
        const credential = FacebookAuthProvider.credentialFromResult(result);
        const accessToken = credential.accessToken;     
        
        

        const docData = {
            user_name: result.user.displayName,
            user_email: result.user.email,
            user_phone: result.user.phoneNumber,
            user_urlphoto: result.user.photoURL,
            user_order_notify: true,
            user_order_email: true,
            user_order_message: true,
            user_info_notify: true,
            user_info_email: true,
            user_info_message: true
        };

        const db = getFirestore(app);
        
        const userRef =   doc(db, "users", uid); 
        setDoc(userRef, docData, { merge:true })
        .then(userRef => {
            console.log("Document Field has been updated successfully");
            window.location = "../Home.html";
        })
        .catch(error => {
            console.log(error);
        })
/*
        // Add a new document with a generated id.
        const docRef = setDoc(doc(db, "users", uid), docData).then((ret) => {
            window.location = "../Home.html";
        });
        */
        return false;
    })
    .catch((error) => {
        // Handle Errors here.
        const errorCode = error.code;
        const errorMessage = error.message;
        // The email of the user's account used.
        const email = error.customData.email;
        // The AuthCredential type that was used.
        const credential = FacebookAuthProvider.credentialFromError(error);

        $("#alert").html("Usuário não encontrado!");
        $("#alert").show();
    });
});

$("#signing").click(function(){
  var email       = $("#user_email").val();
  var password    = $("#user_password").val();

  if(email!="" && password!=""){
      signInWithEmailAndPassword(auth, email, password)
      .then((userCredential) => {
          const user = userCredential.user;
          setCookie('uid',user.uid);
          window.location = "../Home.html";
      })
      .catch((error) => {
          const errorCode = error.code;
          const errorMessage = error.message;
          
          if(errorMessage.indexOf("auth/user-not-found") != -1){ 
              $("#alert").html("Usuário não encontrado!");
              $("#alert").show();
          }
      });
      
  }else{
      if(email=="") $("#user_email").addClass('border border-danger');
      if(password=="") $("#user_password").addClass('border border-danger');
  }
});

$("#resetPassword").click(function(){
  var email       = $("#user_email").val();

  if(email!=""){
      sendPasswordResetEmail(auth, email)
      .then(() => {
          window.location = "../Home.html";
      })
      .catch((error) => {
          const errorCode = error.code;
          const errorMessage = error.message;
          if(errorMessage.indexOf("auth/user-not-found") != -1){ 
              $("#alert").html("Usuário não encontrado!");
              $("#alert").show();
          }
      });
  }else{
      $("#user_email").addClass('border border-danger');
  }
});

function setCookie(cname, cvalue, exdays) {
  alert(cvalue);
  const d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  let expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
      c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
      }
  }
  return "";
}






