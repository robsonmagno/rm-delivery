<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>RM Delivery - Criar Conta</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">



    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <script src="../includes/firebase.js"></script>
    <script type="module">
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
                    const user = JSON.stringify(userCredential.user);
                    $("#user").val(user);

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

                    // Add a new document with a generated id.
                    const docRef = addDoc(collection(db, "users", userCredential.user.uid), docData).then((ret) => {
                        window.location = "../Home.php";
                    });
                    
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
                const user = JSON.stringify(result.user);
                
                $("#user").val(user);
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

                // Add a new document with a generated id.
                const docRef = addDoc(collection(db, "users", result.user.uid), docData).then((ret) => {
                    window.location = "../Home.php";
                });
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
                const user = JSON.stringify(result.user);

                // This gives you a Facebook Access Token. You can use it to access the Facebook API.
                const credential = FacebookAuthProvider.credentialFromResult(result);
                const accessToken = credential.accessToken;     
                
                $("#user").val(user);

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

                // Add a new document with a generated id.
                const docRef = addDoc(collection(db, "users", result.user.uid), docData).then((ret) => {
                    window.location = "../Home.php";
                });
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

    </script>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Criar Conta</h1>
                            </div>
                            <div class="text-center alert alert-danger" style="display: none;" id="alert"></div>
                            <form class="user" name="registerForm" id="registerForm" method="post" action="registerAction.php">
                                <input type="hidden" id="user" name="user" />
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="user_name" name="user_name"
                                        placeholder="Nome">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="user_email" name="user_email"
                                        placeholder="Endereço de Email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="user_password" name="user_password" placeholder="Senha">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="user_rpassword" name="user_rpassword" placeholder="Repetir Senha">
                                    </div>
                                </div>
                                <input type="button" id="register" class="btn btn-primary btn-user btn-block" value="Criar Conta">
                                <hr>
                                <div id="loginWithGoogle" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Entrar com Google
                                </div>

                                <div id="loginWithFacebook" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Entrar com Facebook
                                </div>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="ForgotPassword.php">Esqueci minha senha</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="index.php">Já tem conta? Entre!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>