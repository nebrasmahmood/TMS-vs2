$(".fa-trash-alt").click(function(e){
    let icon = this;
    e.preventDefault();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-light ml-3'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'Are you sure to delete this?',
        text: "You won't be able to revert it after deletion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({
                showConfirmButton: false,
                title: 'Deleted!',
                text: afterDeletionMsg,
                icon: 'success',
            })
            setTimeout(function(){
                icon.closest('form').submit()
            },500)
        } else if (result.dismiss === Swal.DismissReason.cancel) {
        //    nothing
        }
    })
})
