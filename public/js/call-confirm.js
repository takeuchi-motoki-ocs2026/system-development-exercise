window.addEventListener('DOMContentLoaded', function(){
  const overlay = document.getElementById('call-confirm-overlay');
  if(!overlay) return;

  function show(href){
    overlay.style.display = 'flex';
    overlay.dataset.targetHref = href || '';
    // focus management
    const ok = overlay.querySelector('#cc-ok');
    if(ok) ok.focus();
  }
  function hide(){
    overlay.style.display = 'none';
    overlay.dataset.targetHref = '';
  }

  document.addEventListener('click', function(e){
    const el = e.target.closest('a,button');
    if(!el) return;
    const text = (el.textContent || '').replace(/\s+/g,'');
    if(text.includes('店員呼出')){
      e.preventDefault();
      const anchor = el.closest('a');
      const href = anchor ? anchor.getAttribute('href') : null;
      show(href);
    }
  });

  const btnCancel = overlay.querySelector('#cc-cancel');
  const btnOk = overlay.querySelector('#cc-ok');
  if(btnCancel) btnCancel.addEventListener('click', hide);
  if(btnOk) btnOk.addEventListener('click', function(){
    const href = overlay.dataset.targetHref;
    hide();
    if(href){
      window.location.href = href;
    } else {
      window.location.href = '/project/call';
    }
  });

  // close when clicking outside modal
  overlay.addEventListener('click', function(e){
    if(e.target === overlay){ hide(); }
  });
});
