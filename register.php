<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user_count = $stmt->fetchColumn();

        if ($user_count > 0) {
            $error = "Username sudah terdaftar. Silakan gunakan username lain.";
        } else {
            // Insert new user into the database
            $stmt = $pdo->prepare("INSERT INTO users (fullname, phone, username, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fullname, $phone, $username, $password]);
            header("Location: login.php");
            exit;
        }
    } catch (PDOException $e) {
        // Handle unexpected database errors
        $error = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Registrasi</title>
</head>
<body>
<style>
        :root {
            --magnolia: #f7f0f5ff;
            --dun: #decbb7ff;
            --battleship-gray: #8f857dff;
            --walnut-brown: #5c5552ff;
            --van-dyke: #433633ff;
        }
        .bg-magnolia {
            background-color: var(--magnolia);
        }
        .bg-dun {
            background-color: var(--dun);
        }
        .bg-battleship-gray {
            background-color: var(--battleship-gray);
        }
        .bg-walnut-brown {
            background-color: var(--walnut-brown);
        }
        .bg-van-dyke {
            background-color: var(--van-dyke);
        }
        .text-magnolia {
            color: var(--magnolia);
        }
        .text-dun {
            color: var(--dun);
        }
        .text-battleship-gray {
            color: var(--battleship-gray);
        }
        .text-walnut-brown {
            color: var(--walnut-brown);
        }
        .text-van-dyke {
            color: var(--van-dyke);
        }
    </style>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto" src="Hermina.png?color=indigo&shade=600" alt="Your Company" style="height: 100px; width: 100px;">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Daftar Akun</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="#" method="POST">
                <div>
                    <label for="fullname" class="block text-sm/6 font-medium text-gray-900">Full Name</label>
                    <div class="mt-2">
                        <input id="fullname" name="fullname" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                    </div>
                </div>
                <div>
                    <label for="phone" class="block text-sm/6 font-medium text-gray-900">Nomor Telepon</label>
                    <div class="mt-2">
                        <input id="phone" name="phone" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                    </div>
                </div>
                <div>
                    <label for="username" class="block text-sm/6 font-medium text-gray-900">Username</label>
                    <div class="mt-2">
                        <input id="username" name="username" type="text" autocomplete="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                    </div>
                </div>
                <?php if ($error): ?>
                    <div class="text-red-500 text-center"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-van-dyke px-3 py-1.5 text-sm/6 font-semibold text-magnolia shadow-sm hover:bg-battleship-gray focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Daftar</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Sudah memiliki akun? 
                <a href="login.php" class="font-semibold text-indigo-600 hover:text-indigo-500">Login</a>
            </p>
        </div>
    </div>
</body>
</html>