import { SharedData } from "@/types";
import { Button } from "./ui/button";
import { Link, usePage } from "@inertiajs/react";
import { login, logout } from "@/routes";

export function Header() {
    const { auth } = usePage<SharedData>().props;
    return (
        <header>
            <div className="flex items-center justify-between text-slate-700">
                {/* Logo */}
                <a className="group" href="/">
                    <div className="inline-flex items-center gap-4">
                        <img
                            src="/images/pixel-logo.png"
                            alt="DevPups"
                            className="h-16 transition group-hover:scale-105 group-hover:-rotate-6 md:h-20 lg:h-24"
                        />
                        <p className="text-lg font-semibold">Dev Pups</p>
                    </div>
                </a>
                {/* Auth */}
                {auth.user ? (
                    <div className="flex items-center gap-4">
                        <p>Hi, { auth.user.name }!</p>
                        <Button asChild>
                            <Link href={ logout() }> log out</Link>
                        </Button>
                    </div>
                    ) : (
                        <Button asChild>
                            <Link href={ login() }>log in</Link>
                        </Button>
                    )}
            </div>
            {/* Hero copy */}
            <div className="mt-6">
                <h1 className="text-lg font-bold text-slate-600">We've got the best puppies!</h1>
                <p className="text-slate-600">
                    Don't take our word — let the pictures do the talking :)
                </p>
                {!auth.user && (
                    <p className="text-slate-600 mt-4">
                        <Link className="underline hover:no-underline" href={ login() }>Sign in</Link> to keep track of your favorite puppies and add new ones!.
                    </p>
                )}
            </div>
        </header>
    )
}
