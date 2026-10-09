export default function InputError({ message }: { message?: string }) {
    return message ? (<p className='error'>{ message }</p>) : null;
}
