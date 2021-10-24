/**
 * show toast
 * @param title
 * @param icon
 * @param position
 * @default error-toast
 */
export function toast(
    title = "حدث خطأ",
    icon = "error",
    position = "bottom-end"
) {
    // @ts-ignore
    this.$swal.fire({
        toast: true,
        icon,
        position,
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        title,
    });
}

/**
 * show alert
 * @param text
 * @param icon
 * @param confirmButtonText
 * @default success-alert
 */
export async function alert(
    text = "تمت العملية بنجاح",
    icon = "success",
    confirmButtonText = "x"
) {
    // @ts-ignore
    this.$swal.fire({
        icon,
        text,
        confirmButtonText,
    });
}

/**
 * show confirmation dialog
 * @param title
 * @param okText
 * @param cancelText
 */
export async function confirm(
    title = "هل أنت متأكد؟",
    okText = "نعم",
    cancelText = "إلغاء"
) {
    // @ts-ignore
    return await this.$swal.fire({
        title,
        showCancelButton: true,
        confirmButtonText: okText,
        cancelButtonText: cancelText,
    });
}
