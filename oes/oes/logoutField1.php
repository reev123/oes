
 <style>
        
        #logoutImg:hover{
            width:74px;
            height:auto;
        }
        </style>

        
        </header>
        <div style='display:flex;align-items:center;position:fixed;top:20px;right:0;z-index:50;'>
            <p style='background-color:transparent;color:red;text-shadow:1px 1px 1px black;font-size:1.5rem;'><?php echo $_SESSION['instructor_id'];?></p>
          <img src='logout.png' id='logoutImg' onclick='logout()'>
             </div> 
        <script>
        logout=()=>{
            var a=confirm("Are you sure you want to log out?");
            if(a)
            window.location.href='logout1.php';
        }</script>