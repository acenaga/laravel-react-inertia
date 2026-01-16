import { Toaster } from '@/components/ui/sonner';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/react';
import { useEffect } from 'react';
import { toast } from 'sonner';

export function PageWrapper({ children }: { children: React.ReactNode }) {
    const { flash, errors } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash.success) toast.success(flash.success);
        if (flash.warning) toast.warning(flash.warning);
        if (flash.error) toast.error(flash.error);
        if (flash.info) toast.info(flash.info);
        if (errors && Object.keys(errors).length > 0) {
            Object.values(errors).forEach((error) => {
                toast.error(error as string);
            });
        }

    }, [flash]);

    return (
        <>
            <div className="min-h-dvh bg-gradient-to-b from-cyan-200 to-white to-[60vh]">
                {children}
            </div>
            <Toaster position='top-center' richColors closeButton />
        </>
    )
}
