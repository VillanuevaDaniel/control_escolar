/* ============================================================
   Control Escolar — app.js
   jQuery 1.x compatible (IE 8/9/10/11)
   ============================================================ */

$(document).ready(function () {
  /* ── Auto-dismiss flash alerts ───────────────────────── */
  setTimeout(function () {
    $("#flash-container .alert").fadeOut(500, function () {
      $(this).remove();
    });
  }, 4000);

  /* ── Confirmación de eliminación ─────────────────────── */
  $(document).on("click", ".btn-delete", function (e) {
    var msg =
      $(this).data("confirm") ||
      "¿Eliminar este registro? Esta acción no se puede deshacer.";
    if (!confirm(msg)) {
      e.preventDefault();
      return false;
    }
  });


  /* ── Tooltip Bootstrap 4 ─────────────────────────────── */
  if (typeof $.fn.tooltip !== "undefined") {
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
  }

  /* ── Select2 (si está disponible) ────────────────────── */
  if (typeof $.fn.select2 !== "undefined") {
    $(".select2").select2({ width: "100%", language: "es" });
  }

  /* ── Calificación: color dinámico ────────────────────── */
  $(document).on("input change", ".cal-input", function () {
    colorearCalificacion($(this));
  });

  $(".cal-input").each(function () {
    colorearCalificacion($(this));
  });

  function colorearCalificacion($el) {
    var val = parseFloat($el.val());
    $el.removeClass("cal-excelente cal-bien cal-regular cal-reprobado");
    if (isNaN(val)) return;
    if (val >= 9) $el.addClass("cal-excelente");
    else if (val >= 7.5) $el.addClass("cal-bien");
    else if (val >= 6) $el.addClass("cal-regular");
    else $el.addClass("cal-reprobado");
  }

  /* ── Búsqueda en tablas (client-side) ────────────────── */
  $(document).on("keyup", "#table-search", function () {
    var q = $(this).val().toLowerCase();
    $("#main-table tbody tr").each(function () {
      var texto = $(this).text().toLowerCase();
      $(this).toggle(texto.indexOf(q) > -1);
    });
  });

  /* ── Confirmación al salir con formulario modificado ─── */
  var formOriginal = "";
  if ($("form.check-dirty").length) {
    formOriginal = $("form.check-dirty").serialize();
    $(window).on("beforeunload", function () {
      if ($("form.check-dirty").serialize() !== formOriginal) {
        return "Tienes cambios sin guardar. ¿Deseas salir?";
      }
    });
    $("form.check-dirty").on("submit", function () {
      $(window).off("beforeunload");
    });
  }

  /* ── Sidebar toggle en móvil ─────────────────────────── */
  $("#sidebarToggle").on("click", function () {
    $("#sidebar").toggleClass("show");
  });

  /* ── Cerrar sidebar al hacer clic fuera (móvil) ──────── */
  $(document).on("click", function (e) {
    if ($(window).width() < 768) {
      if (!$(e.target).closest("#sidebar, #sidebarToggle").length) {
        $("#sidebar").removeClass("show");
      }
    }
  });

  /* ── Limite de caracteres en textarea ────────────────── */
  $(document).on("input", "[data-maxlength]", function () {
    var max = parseInt($(this).data("maxlength"));
    var cur = $(this).val().length;
    var wrap = $(this).next(".char-count");
    if (!wrap.length) {
      $(this).after('<small class="char-count text-muted"></small>');
      wrap = $(this).next(".char-count");
    }
    wrap.text(cur + "/" + max + " caracteres");
    if (cur > max) {
      wrap.removeClass("text-muted").addClass("text-danger");
    } else {
      wrap.removeClass("text-danger").addClass("text-muted");
    }
  });

  /* ── Promedio automático de calificaciones ───────────── */
  $(document).on("input", ".cal-input", function () {
    recalcularPromedio();
  });

  function recalcularPromedio() {
    var sum = 0,
      count = 0;
    $(".cal-input").each(function () {
      var v = parseFloat($(this).val());
      if (!isNaN(v)) {
        sum += v;
        count++;
      }
    });
    if (count > 0) {
      var avg = (sum / count).toFixed(2);
      $("#promedio-display").text(avg);
    } else {
      $("#promedio-display").text("—");
    }
  }
});
