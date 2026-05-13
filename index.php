<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
        header("Location: results.php");
    } else {
        header("Location: dashboard.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Voting Portal</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .form-box { display: none; }
        .form-box.active { display: block; }
    </style>
</head>
<body>
    <div class="container fade-in">
        <h1>VOTE HUB</h1>
        <p class="subtitle">Secure & Transparent Voting System</p>

        <div class="tabs">
            <div class="tab active" onclick="switchTab('voter')">Voter Portal</div>
            <div class="tab" onclick="switchTab('owner')">Admin Portal</div>
        </div>

        <!-- VOTER SECTION -->
        <div id="voter-section" class="form-box active fade-in">
            <div id="voter-login">
                <form action="login.php" method="POST">
                    <input type="hidden" name="role" value="voter">
                    <div class="form-group">
                        <label>Voter Email</label>
                        <input type="email" name="email" placeholder="name@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit">Sign In as Voter</button>
                </form>
                <div class="toggle-link">New to the platform? <a href="#" onclick="toggleVoterForm('reg')">Create account</a></div>
            </div>
            
            <div id="voter-reg" style="display:none;" class="fade-in">
                <form action="register.php" method="POST">
                    <input type="hidden" name="role" value="voter">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="john@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>Create Password</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit">Complete Registration</button>
                </form>
                <div class="toggle-link">Already a member? <a href="#" onclick="toggleVoterForm('login')">Sign in here</a></div>
            </div>
        </div>

        <!-- OWNER SECTION -->
        <div id="owner-section" class="form-box fade-in">
            <div id="owner-login">
                <form action="login.php" method="POST">
                    <input type="hidden" name="role" value="admin">
                    <div class="form-group">
                        <label>Admin ID (Email)</label>
                        <input type="email" name="email" placeholder="admin@system.com" required>
                    </div>
                    <div class="form-group">
                        <label>Secure Password</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn-admin">Enter Admin Dashboard</button>
                </form>
                <div class="toggle-link">System Authority? <a href="#" onclick="toggleOwnerForm('reg')">Register Admin</a></div>
            </div>
            
            <div id="owner-reg" style="display:none;" class="fade-in">
                <form action="register.php" method="POST">
                    <input type="hidden" name="role" value="admin">
                    <div class="form-group">
                        <label>Admin Full Name</label>
                        <input type="text" name="full_name" placeholder="Administrator" required>
                    </div>
                    <div class="form-group">
                        <label>Official Email</label>
                        <input type="email" name="email" placeholder="admin@domain.com" required>
                    </div>
                    <div class="form-group">
                        <label>Master Password</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn-admin">Register System Admin</button>
                </form>
                <div class="toggle-link">Already registered? <a href="#" onclick="toggleOwnerForm('login')">Admin login</a></div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function switchTab(role) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.form-box').forEach(f => f.classList.remove('active'));
            
            if(role === 'voter') {
                document.querySelector('.tab:nth-child(1)').classList.add('active');
                document.getElementById('voter-section').classList.add('active');
            } else {
                document.querySelector('.tab:nth-child(2)').classList.add('active');
                document.getElementById('owner-section').classList.add('active');
            }
        }

        function toggleVoterForm(type) {
            document.getElementById('voter-login').style.display = type === 'reg' ? 'none' : 'block';
            document.getElementById('voter-reg').style.display = type === 'reg' ? 'block' : 'none';
        }

        function toggleOwnerForm(type) {
            document.getElementById('owner-login').style.display = type === 'reg' ? 'none' : 'block';
            document.getElementById('owner-reg').style.display = type === 'reg' ? 'block' : 'none';
        }
    </script>
</body>
</html>
