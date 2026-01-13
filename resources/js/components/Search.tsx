import { home } from "@/routes";
import { Filters } from "@/types";
import { router } from "@inertiajs/react";
import { Delete } from "lucide-react";
import { useRef } from "react";
import { debounce } from "lodash-es";
export function Search({ filters }: { filters: Filters }) {
    const inputRef = useRef<HTMLInputElement>(null);
    return (
        <div>
            <label htmlFor="search" className="font-medium text-slate-700">
                Search for a character trait
            </label>
            <div className="mt-2 flex items-center gap-4">
                <input
                    defaultValue={filters.search}
                    ref={inputRef}
                    onChange={debounce((e) => {
                        router.get(
                            home().url,
                            { search: e.target.value },
                            {
                                preserveState: true,
                                preserveScroll: true,
                            }
                        )
                    }, 500)}
                    placeholder="playful..."
                    name="search"
                    id="search"
                    type="text"
                    className="w-full max-w-80 bg-white px-4 py-2 ring ring-black/5 focus:ring-2 focus:ring-cyan-500 focus:outline-none text-slate-300"
                />
                <button
                    onClick={
                        () => {
                            router.get(
                            home().url,
                            {  },
                            {
                                preserveScroll: true,
                                preserveState: true,
                                onSuccess: () => {
                                    inputRef.current!.value = ""
                                    inputRef.current?.focus()
                                }
                            }
                        )
                        }
                    }
                    className="inline-block rounded bg-cyan-300 px-4 py-2 !pr-3 !pl-2.5 font-medium text-cyan-900 hover:bg-cyan-200 focus:ring-2 focus:ring-cyan-500 focus:outline-none">
                    <Delete />
                </button>
            </div>
        </div>
    )
}
