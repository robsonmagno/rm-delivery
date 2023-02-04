<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>RM Delivery - Esqueci minha senha</title>
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

        $("#resetPassword").click(function(){
            var email       = $("#user_email").val();

            if(email!=""){
                sendPasswordResetEmail(auth, email)
                .then(() => {
                    window.location = "../Home.php";
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

        onAuthStateChanged(auth, (user) => {
            if (user) {
                // User is signed in, see docs for a list of available properties
                // https://firebase.google.com/docs/reference/js/firebase.User
                const uid = user.uid;
                window.location = "../Home.php";
            }
        });
    </script>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Esqueceu sua senha?</h1>
                                        <p class="mb-4">Nós entendemos, coisas acontecem. Basta digitar seu endereço de e-mail abaixo
                                            e enviaremos um link para redefinir sua senha!</p>
                                    </div>
                                    <div class="text-center alert alert-danger" style="display: none;" id="alert"></div>
                                    <form class="user" name="resetPasswordForm" id="resetPasswordForm" method="post" action="resetPasswordAction.php">
                                        <input type="hidden" id="user" name="user" />
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="user_email" name="user_email" aria-describedby="emailHelp"
                                                placeholder="Endereço de Email..." required>
                                        </div>
                                        <input type="button" id="resetPassword" class="btn btn-primary btn-user btn-block" value="Redefinir Senha">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="Register.php">Criar Conta</a>
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