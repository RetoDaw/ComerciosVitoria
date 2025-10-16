    
    const openBtn = document.getElementById('openPopup');
    const closeBtn = document.getElementById('closePopup');
    const overlay = document.getElementById('overlay');

    openBtn.addEventListener('click', () => overlay.style.display = 'flex');
    closeBtn.addEventListener('click', () => overlay.style.display = 'none');
    overlay.addEventListener('click', e => {
      if (e.target === overlay) overlay.style.display = 'none';
    });
