  // sidebar  hide and show 
  const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');
      const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');

      toggleSidebarBtn.addEventListener('click', () => {
        sidebar.classList.toggle('sidebar-hidden');
        mainContent.classList.toggle('main-content-full');
        toggleSidebarBtn.classList.toggle('hidden');
        toggleSidebarBtn.innerHTML = sidebar.classList.contains('sidebar-hidden') 
          ? '<i class="fas fa-angle-right"></i>' 
          : '<i class="fas fa-angle-left"></i>';
      });

      // form js 

        const steps = document.querySelectorAll('.step');
        const nextBtns = document.querySelectorAll('.next-btn');
        const prevBtns = document.querySelectorAll('.prev-btn');
        let currentStep = 0;

        function showStep(index) {
            steps.forEach((step, idx) => {
                step.classList.toggle('d-none', idx !== index);
            });
        }

        nextBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
        });

        prevBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });

        showStep(currentStep);
        document.getElementById("startRegistration").addEventListener("click", function() {
        document.getElementById("welcomeMessage").classList.add("d-none"); // Hide welcome message
        document.getElementById("registrationFormContainer").classList.remove("d-none"); // Show form
        document.querySelector(".step-1").classList.remove("d-none"); // Show first step
    });

    const scan = document.getElementById('scan');
      const scan_animation = document.getElementById('scan-animation');
      const thecard = document.getElementById('thecard');
      scan.addEventListener('click',  function(){
        event.preventDefault();
        thecard.classList.remove('d-none');
        scan_animation.classList.remove('d-none');
      });