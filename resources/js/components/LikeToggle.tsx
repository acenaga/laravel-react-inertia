import { Heart, LoaderCircle } from "lucide-react";
import { Puppy, SharedData } from "../types";
import { Link, usePage, useForm } from "@inertiajs/react";
import { like } from "@/routes/puppies";
import clsx from "clsx";

export function LikeToggle({ puppy }: { puppy: Puppy, }) {
    const { auth } = usePage<SharedData>().props;
    const { processing, patch } = useForm();
    return (
        <form
            className="h-full"
            onSubmit={(e) => {
                e.preventDefault();
                patch(like(puppy.id).url, {
                    preserveScroll: true,
                });
            }}
        >
            <button
                type="submit"
                disabled={!auth.user || processing}
                className={clsx('group', !auth.user && 'cursor-not-allowed opacity-50')}
            >
                {processing ? (
                <LoaderCircle className=" hidden animate-spin stroke-slate-300" />
                ) : (
                <Heart
                    className={clsx(
                        auth.user && puppy.likedBy.includes(auth.user.id)
                            ? "fill-pink-500 stroke-none"
                            : "stroke-slate-200 group-hover:stroke-slate-300",
                    )
                    }
                />)}

            </button>
        </form>
    )
}
