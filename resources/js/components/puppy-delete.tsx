import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import { Puppy } from '@/types';
import { useForm } from '@inertiajs/react';
import { clsx } from 'clsx';
import { LoaderCircle, TrashIcon } from 'lucide-react';
import { useState } from 'react';

export function PuppyDelete({ puppy }: { puppy: Puppy }) {
    const { processing, delete: destroy } = useForm({});
    const [open, setOpen] = useState(false);
    return (
        <div>
            <AlertDialog open={open} onOpenChange={setOpen}>
                <AlertDialogTrigger asChild>
                    <Button className="group/delete bg-background/30 hover:bg-background" size="icon" variant="outline" aria-label="Delete Puppy">
                        <TrashIcon className="group-hover/delete:stroke-destructive size-4" />
                    </Button>
                </AlertDialogTrigger>

                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                        <AlertDialogDescription>
                            Who in their right mind would want to delete {puppy.name}? Seriously? This action cannot be undone.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <form
                            onSubmit={(e) => {
                                e.preventDefault();
                                destroy(`/puppies/puppy/${puppy.id}`, {
                                    preserveScroll: true,
                                });
                            }}
                        >
                            <Button className="relative disabled:opacity-100" disabled={processing} type="submit">
                                {processing && (
                                    <div className="absolute inset-0 flex items-center justify-center">
                                        <LoaderCircle className="stroke-primary-foreground size-5 animate-spin" />
                                    </div>
                                )}
                                <span className={clsx(processing && 'invisible')}>Delete {puppy.name}</span>
                            </Button>
                        </form>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </div>
    );
}
