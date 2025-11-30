<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <ul class="list-unstyled mb-0">
                            <li><a href="{{ url('/') }}">Situs</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <ul class="list-unstyled mb-0">
                            <li><a href="#">Second link</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <ul class="list-unstyled mb-0">
                            <li><a href="#">Third link</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <ul class="list-unstyled mb-0">
                            <li><a href="#">Fourth link</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                All Access Managed By Super Admin
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item"><a href="./docs/index.html">Documentation</a></li>
                            <li class="list-inline-item"><a href="./faq.html">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a href="https://github.com/tabler/tabler" class="btn btn-outline-primary btn-sm">Source
                            code</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
                Copyright © 2025 <a href=".">{{ env('APP_NAME') }}</a>. Developed by <a href="#"
                    target="_blank">Harumi Project</a> All rights reserved.
            </div>
        </div>
    </div>
</footer>
<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<!-- Data table plugin-->
<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<!-- Custom Script -->
<script>
    var renderAsHtml = function(data, type, full) {
        return decHTMLifEnc(data);
    };
    var isEncHTML = function(str) {
        if (str.search(/&amp;/g) != -1 || str.search(/&lt;/g) != -1 || str.search(/&gt;/g) != -1)
            return true;
        else
            return false;
    };

    var decHTMLifEnc = function(str) {
        if (isEncHTML(str))
            return str.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>');
        return str;
    }
</script>
<script>
    function find_data(id) {
        $.ajax({
            url: '{{ Request::url() }}/find/' + id,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                set_value(dataResult);
            }
        });
    }

    function cekStat(assignmentStat, targetStat) {
        return assignmentStat === targetStat ? 'disabled' : '';
    }
    /**
     * Set HTTP method spoofing untuk Laravel form
     * @param {string} formId - id form (tanpa #)
     * @param {string} method - POST | PUT | DELETE
     */
    function setFormMethod(formId, method) {
        const form = $('#' + formId);

        if (!form.length) {
            console.warn(`Form dengan id "${formId}" tidak ditemukan`);
            return;
        }

        form.find('input[name="_method"]').remove();

        if (method.toUpperCase() !== 'POST') {
            form.append(`
                <input type="hidden" name="_method" value="${method.toUpperCase()}">
            `);
        }
    }

    function showToast(message, type = 'success', delay = 3000) {

        const config = {
            success: {
                bg: 'bg-success',
                icon: 'fa-check-circle',
                textColor: 'text-white'
            },
            error: {
                bg: 'bg-danger',
                icon: 'fa-times-circle',
                textColor: 'text-white'
            },
            warning: {
                bg: 'bg-warning',
                icon: 'fa-exclamation-triangle',
                textColor: 'text-dark'
            },
            info: {
                bg: 'bg-info',
                icon: 'fa-info-circle',
                textColor: 'text-white'
            }
        };

        const t = config[type] || config.info;
        const toastId = 'toast-' + Date.now();

        const toastHTML = `
    <div id="${toastId}" class="toast" data-delay="${delay}">
        <div class="toast-body ${t.textColor} ${t.bg}">
          <i class="fas ${t.icon} ${t.textColor} mr-2"></i> ${message}
        </div>
    </div>
`;

        $('#toast-container').append(toastHTML);

        $('#' + toastId).toast('show')
            .on('hidden.bs.toast', function() {
                $(this).remove();
            });
    }

    $("body").on("click", ".btn-hapus", function() {
        var x = jQuery(this).attr("data-id");
        var y = jQuery(this).attr("data-handler");
        var xy = x + '-' + y;
        event.preventDefault()
        Swal.fire({
            title: 'Hapus Data ?',
            text: "Data yang dihapus tidak dapat dikembalikan !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Data Dihapus!',
                    '',
                    'success'
                );
                document.getElementById('delete-form-' + xy).submit();
            }
        });
    })
</script>
<script>
    $(function() {
        @if (session('info'))
            showToast("{{ session('info') }}", "info");
        @endif
        @if (session('success'))
            showToast("{{ session('success') }}", "success");
        @endif
        @if (session('warning'))
            showToast("{{ session('warning') }}", "warning");
        @endif
        @if (session('delete'))
            showToast("{{ session('delete') }}", "error");
        @endif
    })
</script>
