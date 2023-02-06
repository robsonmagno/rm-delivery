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

            const companyData = {
                company_contact: userCredential.user.displayName,
                company_email: userCredential.user.email,
                company_phone: userCredential.user.phoneNumber,
                company_name: userCredential.user.displayName,
                company_urlphoto: result.user.photoURL,
                company_order_notify: true,
                company_order_email: true,
                company_order_message: true,
                company_info_notify: true,
                company_info_email: true,
                company_info_message: true
            };

            const db = getFirestore(app);
            
            const companyRef =   doc(db, "companies", user.uid); 
            setDoc(companyRef, companyData, { merge:true })
            .then(companyRef => {
                console.log("Document Field has been updated successfully");
                window.location = "../";
            })
            .catch(error => {
                console.log(error);
            })
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
        
        const companyData = {
            company_contact: result.user.displayName,
            company_email: result.user.email,
            company_phone: result.user.phoneNumber,
            company_name: result.user.displayName,
            company_urlphoto: result.user.photoURL,
            company_order_notify: true,
            company_order_email: true,
            company_order_message: true,
            company_info_notify: true,
            company_info_email: true,
            company_info_message: true
        };

        const db = getFirestore(app);
        
        const companyRef =   doc(db, "companies", user.uid); 
        setDoc(companyRef, companyData, { merge:true })
        .then(companyRef => {
            console.log("Document Field has been updated successfully");
            window.location = "../";
        })
        .catch(error => {
            console.log(error);
        })
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
        var uid = result.user.uid;
        // This gives you a Facebook Access Token. You can use it to access the Facebook API.
        const credential = FacebookAuthProvider.credentialFromResult(result);
        const accessToken = credential.accessToken;  

        const companyData = {
            company_contact: result.user.displayName,
            company_email: result.user.email,
            company_phone: result.user.phoneNumber,
            company_name: result.user.displayName,
            company_urlphoto: result.user.photoURL,
            company_order_notify: true,
            company_order_email: true,
            company_order_message: true,
            company_info_notify: true,
            company_info_email: true,
            company_info_message: true
        };

        const db = getFirestore(app);
        
        const companyRef =   doc(db, "companies", uid); 
        setDoc(companyRef, companyData, { merge:true })
        .then(companyRef => {
            console.log("Document Field has been updated successfully");
            window.location = "../";
        })
        .catch(error => {
            console.log(error);
        })
        
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
          window.location = "../";
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
          window.location = "../";
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








